<?php
declare(strict_types = 1);

namespace Phocate\Parsing;

use Phocate\Parsing\Data\ClassObject;
use Phocate\Parsing\Data\FileObject;
use Phocate\Parsing\Data\NamespaceObject;
use Phocate\Parsing\Data\UseObject;
use Phocate\Parsing\Token\Match;
use Phocate\Parsing\Token\Token;
use Phocate\Parsing\Token\Tokens;
use Phocate\Parsing\Token\TokensParser;

class FileParser
{
    public static function fqn_parser(): TokensParser
    {
        return (new Match(T_STRING))->sepBy(new Match(T_NS_SEPARATOR));
    }

    public static function extends_parser(string $class_name): EitherParser
    {
        return (new Match(T_WHITESPACE))
            ->before(new Match(T_EXTENDS))
            ->before(new Match(T_WHITESPACE))
            ->before(new Match(T_STRING))
            ->mapToEitherParser(function (array $tokens) use ($class_name) {
                return new ClassObject($class_name, $tokens[0]->contents, []);
            });
    }

    public static function implements_parser(string $class_name): EitherParser
    {
        return (new Match(T_WHITESPACE))
            ->before(new Match(T_IMPLEMENTS))
            ->before(new Match(T_WHITESPACE))
            ->before(new Match(T_STRING))
            ->mapToEitherParser(function (array $tokens) use ($class_name) {
                return new ClassObject($class_name, '', [$tokens[0]->contents]);
            });
    }

    public static function namespace_parser(): EitherParser
    {
        return (new Match(T_NAMESPACE))
            ->before(new Match(T_WHITESPACE))
            ->before(self::fqn_parser())
            ->mapToEitherParser(function (array $tokens): Either {
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                return new NamespaceObject(implode('\\', $strings));
            });
    }

    public static function class_parser(): EitherParser
    {
        return (new Match(T_CLASS))
            ->before(new Match(T_WHITESPACE))
            ->before(new Match(T_STRING))
            ->bindEither(function ($tokens): EitherParser {
                $class_name = $tokens[0]->contents;
                $normal = new PureEitherParser(new ClassObject($class_name, '', []));
                return self::extends_parser($class_name)
                    ->ifFail(self::implements_parser($class_name))
                    ->ifFail($normal);
            });
    }

    public static function use_parser()
    {
        return (new Match(T_USE))
            ->before(new Match(T_WHITESPACE))
            ->before(
                self::fqn_parser()
            )
            ->mapToEitherParser(function (array $tokens): Either {
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                $FQN = implode('\\', $strings);
                return new UseObject($FQN, $tokens[count($tokens) - 1]->contents);
            });
    }


    public function parser(string $path, Tokens $tokens): FileResult
    {
        $namespace_stmt_p = self::namespace_parser();
        $class_stmt_p = self::class_parser();
        $use_stmt_p = self::use_parser();
        $body_p = $namespace_stmt_p
            ->ifFail($use_stmt_p)
            ->ifFail($class_stmt_p);
        $file = new FileObject();
        $file->path = $path;
        /** @var NamespaceObject $namespace */
        $namespace = null;

        while (!$tokens->nil()) {
            $result = $body_p->parse($tokens);
            if ($result instanceof NothingEitherResult) {
                $tokens = $tokens->tail();
            } else if ($result instanceof  JustEitherResult) {
                $tokens = $result->tokens;
                $object = $result->result;
                if ($object instanceof NamespaceObject) {
                    $namespace = $object;
                    $file->namespaces[] = $namespace;
                } else if ($object instanceof UseObject) {
                    if ($namespace === null) {
                        $namespace = new NamespaceObject('\\');
                        $file->namespaces[] = $namespace;
                    }
                    $namespace->usages[] = $object;
                } else if ($object instanceof ClassObject) {
                    if ($namespace === null) {
                        $namespace = new NamespaceObject('\\');
                        $file->namespaces[] = $namespace;
                    }
                    $namespace->classes[] = $object;
                }
            }
        }
        return new FileResult($file, $tokens);
    }
}
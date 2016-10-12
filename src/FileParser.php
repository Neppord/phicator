<?php
declare(strict_types = 1);

namespace Phocate;

use Phocate\Token\Match;
use Phocate\Token\Token;
use Phocate\Token\Tokens;

class FileParser
{
    public static function namespace_parser(): StringParser
    {
        return (new Match(T_NAMESPACE))
            ->before(new Match(T_WHITESPACE))
            ->before(
                (new Match(T_STRING))->sepBy(new Match(T_NS_SEPARATOR))
            )->mapToStringParser(function (array $tokens): String {
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                return implode('\\', $strings);
            });
    }

    public static function class_parser(): StringParser
    {
        return (new Match(T_CLASS))
            ->before(new Match(T_WHITESPACE))
            ->before(new Match(T_STRING))
            ->mapToStringParser(function (array $tokens): String {
                $strings = array_map(function (Token $token) {
                    return $token->contents;
                },$tokens);
                return implode('', $strings);
            });
    }

    public function parser(string $path, Tokens $tokens): FileResult
    {
        $namespace_stmt_p = self::namespace_parser();
        $class_stmt_p = self::class_parser();
        $file = new FileObject();
        $file->path = $path;
        $namespace = null;

        while (!$tokens->nil()) {
            $result = $namespace_stmt_p->parse($tokens);
            if ($result instanceof NothingStringResult) {
                $result = $class_stmt_p->parse($tokens);
                if ($result instanceof NothingStringResult) {
                    $tokens = $tokens->tail();
                } else {
                    $class = new ClassObject();
                    $class->name = $result->result;
                    if($namespace === null) {
                        $namespace = new NamespaceObject();
                        $namespace->name =  '\\';
                        $file->namespaces[] = $namespace;
                    }
                    $namespace->classes[] = $class;
                    $tokens = $result->tokens;
                }
            } else {
                $namespace = new NamespaceObject();
                $namespace->name =  $result->result;
                $file->namespaces[] = $namespace;
                $tokens = $result->tokens;
            }
        }
        return new FileResult($file, $tokens);
    }
}
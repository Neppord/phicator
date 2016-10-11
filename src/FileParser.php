<?php
declare(strict_types = 1);

namespace Phocate;


use Phocate\Token\Tokens;

class FileParser
{
    public function parser(string $path, Tokens $tokens): FileResult
    {
        $namespace_stmt_p = new NamespaceStmtParser();
        $class_stmt_p = new ClassStmtParser();
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
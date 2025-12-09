<?php
/**
 * Script de Diagnóstico .htaccess
 * Coloque este arquivo em: public/test-htaccess.php
 * Acesse via navegador
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de .htaccess - RH 5º Distrito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .ok { background: #d4edda; color: #155724; }
        .warning { background: #fff3cd; color: #856404; }
        .error { background: #f8d7da; color: #721c24; }
        h1 { color: #333; }
        h2 { color: #666; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .info { background: #d1ecf1; padding: 15px; border-left: 4px solid #0c5460; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>🔍 Diagnóstico de .htaccess e Servidor</h1>

    <!-- PHP Info -->
    <div class="card">
        <h2>1. Informações do PHP</h2>
        <?php
        echo "<strong>Versão do PHP:</strong> " . phpversion() . "<br>";
        echo "<strong>SAPI:</strong> " . php_sapi_name() . "<br>";
        echo "<strong>Memória Limite:</strong> " . ini_get('memory_limit') . "<br>";
        echo "<strong>Max Execution Time:</strong> " . ini_get('max_execution_time') . "s<br>";
        echo "<strong>Upload Max Size:</strong> " . ini_get('upload_max_filesize') . "<br>";
        echo "<strong>Post Max Size:</strong> " . ini_get('post_max_size') . "<br>";
        ?>
    </div>

    <!-- Apache Modules -->
    <div class="card">
        <h2>2. Módulos do Apache</h2>
        <?php
        if (function_exists('apache_get_modules')) {
            $modules = apache_get_modules();
            $important = ['mod_rewrite', 'mod_ssl', 'mod_headers'];

            foreach ($important as $mod) {
                $status = in_array($mod, $modules);
                $class = $status ? 'ok' : 'error';
                $text = $status ? '✅ Ativo' : '❌ Inativo';
                echo "<span class='status $class'>$mod: $text</span><br>";
            }

            echo "<br><details><summary>Ver todos os módulos</summary><pre>";
            print_r($modules);
            echo "</pre></details>";
        } else {
            echo "<span class='status warning'>⚠️ Não é possível verificar (CGI/FastCGI)</span><br>";
            echo "<small>Servidor não expõe lista de módulos Apache</small>";
        }
        ?>
    </div>

    <!-- .htaccess -->
    <div class="card">
        <h2>3. Verificação do .htaccess</h2>
        <?php
        $htaccess = '.htaccess';

        if (file_exists($htaccess)) {
            echo "<span class='status ok'>✅ Arquivo .htaccess existe</span><br><br>";

            $size = filesize($htaccess);
            $perms = substr(sprintf('%o', fileperms($htaccess)), -4);

            echo "<strong>Tamanho:</strong> $size bytes<br>";
            echo "<strong>Permissões:</strong> $perms ";
            echo ($perms == '0644' ? "<span class='status ok'>✅ OK</span>" : "<span class='status warning'>⚠️ Recomendado: 644</span>");
            echo "<br><br>";

            echo "<details><summary>Ver conteúdo do .htaccess</summary>";
            echo "<pre>" . htmlspecialchars(file_get_contents($htaccess)) . "</pre>";
            echo "</details>";
        } else {
            echo "<span class='status error'>❌ Arquivo .htaccess NÃO existe</span><br>";
            echo "<div class='info'>⚠️ <strong>Ação necessária:</strong> Crie o arquivo .htaccess na pasta public/</div>";
        }
        ?>
    </div>

    <!-- Laravel Detection -->
    <div class="card">
        <h2>4. Detecção do Laravel</h2>
        <?php
        $laravelPaths = [
            '../vendor/autoload.php' => 'Autoload do Composer',
            '../bootstrap/app.php' => 'Bootstrap do Laravel',
            '../.env' => 'Arquivo de configuração',
            '../artisan' => 'CLI Artisan'
        ];

        foreach ($laravelPaths as $path => $desc) {
            $exists = file_exists($path);
            $class = $exists ? 'ok' : 'error';
            $text = $exists ? '✅' : '❌';
            echo "<span class='status $class'>$text $desc</span><br>";
        }

        // Tentar carregar Laravel
        echo "<br>";
        if (file_exists('../vendor/autoload.php')) {
            try {
                require '../vendor/autoload.php';
                $app = require_once '../bootstrap/app.php';

                echo "<span class='status ok'>✅ Laravel carregado com sucesso</span><br>";

                // Verificar versão
                echo "<br><strong>Versão do Laravel:</strong> " . app()->version() . "<br>";

                // Verificar rotas
                echo "<br><strong>Rotas registradas:</strong><br>";
                $routes = app('router')->getRoutes();
                $adminCount = 0;
                $totalCount = 0;

                foreach ($routes as $route) {
                    $totalCount++;
                    if (str_contains($route->uri(), 'admin')) {
                        $adminCount++;
                    }
                }

                echo "Total de rotas: $totalCount<br>";
                echo "Rotas admin: $adminCount<br>";

                // Verificar rotas de login específicas
                echo "<br><details><summary>Ver rotas do /admin/login</summary><pre>";
                foreach ($routes as $route) {
                    if (str_contains($route->uri(), 'admin/login')) {
                        echo "URI: " . $route->uri() . "\n";
                        echo "Methods: " . implode(', ', $route->methods()) . "\n";
                        echo "Name: " . $route->getName() . "\n\n";
                    }
                }
                echo "</pre></details>";

            } catch (Exception $e) {
                echo "<span class='status error'>❌ Erro ao carregar Laravel</span><br>";
                echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            }
        } else {
            echo "<span class='status error'>❌ Laravel não detectado</span>";
        }
        ?>
    </div>

    <!-- Permissions -->
    <div class="card">
        <h2>5. Permissões de Diretórios</h2>
        <?php
        $dirs = [
            '../storage' => 'Storage',
            '../storage/app' => 'Storage/App',
            '../storage/framework' => 'Storage/Framework',
            '../storage/logs' => 'Storage/Logs',
            '../bootstrap/cache' => 'Bootstrap/Cache'
        ];

        foreach ($dirs as $dir => $name) {
            if (is_dir($dir)) {
                $perms = substr(sprintf('%o', fileperms($dir)), -4);
                $writable = is_writable($dir);

                $class = $writable ? 'ok' : 'error';
                $text = $writable ? '✅' : '❌';

                echo "<span class='status $class'>$text $name: $perms " . ($writable ? 'Gravável' : 'Não gravável') . "</span><br>";
            } else {
                echo "<span class='status error'>❌ $name: Diretório não existe</span><br>";
            }
        }
        ?>
    </div>

    <!-- Environment -->
    <div class="card">
        <h2>6. Variáveis de Ambiente</h2>
        <?php
        $envVars = [
            'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
            'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'REQUEST_SCHEME' => $_SERVER['REQUEST_SCHEME'] ?? 'N/A',
            'HTTP_HOST' => $_SERVER['HTTP_HOST'] ?? 'N/A',
            'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? 'N/A',
        ];

        echo "<table style='width:100%; border-collapse: collapse;'>";
        foreach ($envVars as $key => $value) {
            echo "<tr style='border-bottom: 1px solid #ddd;'>";
            echo "<td style='padding: 8px; font-weight: bold;'>$key</td>";
            echo "<td style='padding: 8px;'>" . htmlspecialchars($value) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>

    <!-- Recommendations -->
    <div class="card">
        <h2>7. Recomendações</h2>
        <?php
        $issues = [];

        // Verificar mod_rewrite
        if (function_exists('apache_get_modules')) {
            if (!in_array('mod_rewrite', apache_get_modules())) {
                $issues[] = "❌ <strong>mod_rewrite não está ativo.</strong> Entre em contato com o suporte da hospedagem.";
            }
        }

        // Verificar .htaccess
        if (!file_exists('.htaccess')) {
            $issues[] = "❌ <strong>Arquivo .htaccess não existe.</strong> Crie o arquivo conforme documentação.";
        }

        // Verificar permissões
        if (!is_writable('../storage')) {
            $issues[] = "❌ <strong>Pasta storage não é gravável.</strong> Execute: chmod -R 775 storage";
        }

        // Verificar PHP
        if (version_compare(phpversion(), '8.2.0', '<')) {
            $issues[] = "⚠️ <strong>PHP " . phpversion() . " detectado.</strong> Laravel 11 requer PHP 8.2+";
        }

        if (empty($issues)) {
            echo "<div class='info' style='background: #d4edda; border-color: #28a745;'>";
            echo "✅ <strong>Tudo parece estar OK!</strong>";
            echo "</div>";
        } else {
            foreach ($issues as $issue) {
                echo "<div class='info' style='background: #f8d7da; border-color: #dc3545;'>";
                echo $issue;
                echo "</div>";
            }
        }
        ?>
    </div>

    <!-- Actions -->
    <div class="card">
        <h2>8. Ações Recomendadas</h2>
        <ol>
            <li>Se <strong>mod_rewrite está inativo</strong>, entre em contato com suporte da hospedagem</li>
            <li>Se <strong>.htaccess não existe</strong>, crie o arquivo com o conteúdo correto</li>
            <li>Se <strong>permissões estão incorretas</strong>, ajuste via FTP ou cPanel</li>
            <li>Se <strong>rotas admin não aparecem</strong>, limpe o cache:
                <pre>rm -rf bootstrap/cache/*.php</pre>
            </li>
            <li>Após corrigir, <strong>delete este arquivo</strong> (segurança)</li>
        </ol>
    </div>

    <div style="text-align: center; color: #666; margin-top: 30px;">
        <p>Sistema RH - 5º Distrito de Infraestrutura de Magé</p>
        <p><small>⚠️ Delete este arquivo após o diagnóstico por questões de segurança</small></p>
    </div>
</body>
</html>

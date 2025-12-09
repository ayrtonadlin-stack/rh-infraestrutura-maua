<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário admin padrão
        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@5distrito.gov.br',
            'password' => bcrypt('admin123'),
        ]);

        // Popular funcionários de exemplo
        $this->call([
            FuncionarioSeeder::class,
        ]);

        $this->command->info('✅ Database populada com sucesso!');
        $this->command->info('📧 Email: admin@5distrito.gov.br');
        $this->command->info('🔑 Senha: admin123');
    }
}

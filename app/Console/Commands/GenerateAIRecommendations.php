<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pengguna;
use App\Http\Controllers\AIRecommendationController;
use App\Services\GeminiAIService;

class GenerateAIRecommendations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:generate-recommendations 
                            {--user_id= : Generate for specific user ID}
                            {--all : Generate for all users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate AI book recommendations for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🤖 Starting AI Recommendation Generation...');
        $this->newLine();

        $userId = $this->option('user_id');
        $all = $this->option('all');

        if ($userId) {
            // Generate for specific user
            $this->generateForUser($userId);
        } elseif ($all) {
            // Generate for all users
            $this->generateForAllUsers();
        } else {
            $this->error('Please specify --user_id=X or --all');
            return 1;
        }

        $this->newLine();
        $this->info('✅ AI Recommendation generation completed!');
        return 0;
    }

    private function generateForUser($userId)
    {
        $user = Pengguna::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found!");
            return;
        }

        $this->info("Generating recommendations for: {$user->nama_pengguna}");

        $controller = app(AIRecommendationController::class);

        try {
            // Call private method via reflection (for artisan command)
            $reflection = new \ReflectionClass($controller);
            $method = $reflection->getMethod('generateRecommendations');
            $method->setAccessible(true);

            $result = $method->invoke($controller, $userId);

            if ($result) {
                $this->info("✓ Successfully generated " . count($result->recommended_books) . " recommendations");
            } else {
                $this->warn("⚠ No recommendations generated (not enough history or books)");
            }
        } catch (\Exception $e) {
            $this->error("✗ Error: " . $e->getMessage());
        }
    }

    private function generateForAllUsers()
    {
        $users = Pengguna::where('level_akses', 'anggota')->get();

        $this->info("Found {$users->count()} members");
        $this->newLine();

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($users as $user) {
            try {
                $controller = app(AIRecommendationController::class);

                $reflection = new \ReflectionClass($controller);
                $method = $reflection->getMethod('generateRecommendations');
                $method->setAccessible(true);

                $result = $method->invoke($controller, $user->id_pengguna);

                if ($result) {
                    $success++;
                } else {
                    $skipped++;
                }
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("Failed for user {$user->nama_pengguna}: " . $e->getMessage());
            }

            $bar->advance();

            // Small delay to avoid API rate limiting (Gemini: 60 req/min)
            usleep(1000000); // 1 second delay = max 60/min
        }

        $bar->finish();
        $this->newLine(2);

        // Summary
        $this->info("📊 Summary:");
        $this->info("  ✓ Success: {$success}");
        $this->warn("  ⊘ Skipped: {$skipped}");
        $this->error("  ✗ Failed: {$failed}");
    }
}

<?php

namespace App\Console\Commands;

use App\Services\OpenAIService;
use Illuminate\Console\Command;

class TestOpenAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openai:test {--name=John} {--age=25} {--location=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OpenAI pickup line generation';

    /**
     * Execute the console command.
     */
    public function handle(OpenAIService $openAIService)
    {
        $name = $this->option('name');
        $age = $this->option('age') ? (int) $this->option('age') : null;
        $location = $this->option('location') ?: null;

        $this->info('Testing OpenAI pickup line generation...');
        $this->info("Name: {$name}");
        if ($age) $this->info("Age: {$age}");
        if ($location) $this->info("Location: {$location}");
        $this->newLine();

        try {
            // Test pickup line generation
            $this->info('Generating pickup line...');
            $pickupLine = $openAIService->generatePickupLine($name, $age, $location);
            $this->line("Pickup Line: {$pickupLine}");
            $this->newLine();

            // Test self-description generation
            $this->info('Generating self-description...');
            $selfDescription = $openAIService->generateSelfDescriptionLine($age, $location);
            $this->line("Self Description: {$selfDescription}");
            
            $this->newLine();
            $this->success('OpenAI integration test completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('OpenAI test failed: ' . $e->getMessage());
            $this->warn('Make sure you have set your OPENAI_API_KEY in the .env file');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

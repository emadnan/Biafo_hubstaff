<?php

namespace App\Console\Commands;

use App\Models\ProjectScreenshotsAttechments;
use App\Models\ProjectScreenshotsTiming;
use Illuminate\Console\Command;

class DeleteOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:previous_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For delete All old data till two months ago';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $twoMonthsAgo = now()->subMonths(2);
        $firstDayOfPresentMonth = now()->startOfMonth();
        $twoMonthsAgo = $firstDayOfPresentMonth->subMonth(2);
        $project_ss = ProjectScreenshotsAttechments::where('created_at', '<', $twoMonthsAgo)
            ->get();
        foreach ($project_ss as $project) {
            if ($project->path_url != '') {
                $url = $project->path_url;
                $filename = pathinfo($url, PATHINFO_BASENAME);
                $filePath = public_path('screenshots/' . $filename);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        $this->info('Old data deleted successfully.');
    }
}

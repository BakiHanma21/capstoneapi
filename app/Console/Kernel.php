use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Api\SkilledWorkerController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Process account deletions daily at midnight
        $schedule->call(function () {
            app(SkilledWorkerController::class)->processPendingDeletions();
        })->daily();
    }
} 
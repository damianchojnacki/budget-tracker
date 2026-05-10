<?php

namespace App\Console\Commands;

use App\Facades\Rate;
use App\Models\Currency;
use Illuminate\Console\Command;

class UpdateCurrencyRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Currency::all()->each(function (Currency $currency): void {
            $rate = Rate::get($currency);

            if (!$rate) {
                $this->output->warning("Could not get rate for {$currency->code}.");

                return;
            }

            $currency->update([
                'rate' => $rate,
            ]);
        });

        return 0;
    }
}

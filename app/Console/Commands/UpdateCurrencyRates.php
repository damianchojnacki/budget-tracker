<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Rate;

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
        Currency::all()->each(function (Currency $currency) {
            $rate = Rate::get($currency);

            if(!$rate){
                $this->output->warning("Could not get rate for $currency->code.");
                return;
            }

            $currency->update([
                'rate' => $rate
            ]);
        });

        return 0;
    }
}

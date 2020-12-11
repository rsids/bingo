<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Support\CardGenerator;
use Illuminate\Console\Command;

class GenerateCardPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bingo:card {card}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the pdf for the given card';

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
    public function handle(CardGenerator $cardGenerator)
    {
        $card = Card::find($this->argument('card'));
        $cardGenerator->generate($card);

        return 0;
    }
}

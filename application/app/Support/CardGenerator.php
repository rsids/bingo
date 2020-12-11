<?php

namespace App\Support;

use App\Models\Card;
use App\Models\Track;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class CardGenerator
{

    public function generate(Card $card)
    {
        $trackList = explode(',', $card->tracks);
        $tracks = Track::whereIn('id', $trackList)->get();

        $pdf = $this->createBasePdf();

        $table = $this->generateTable($tracks);
        $footer = "<p>{$card->round->title} - {$card->id}</p>";

        $pdf->WriteHTML(file_get_contents( base_path() . '/resources/css/bingo.css'), HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($table . $footer, HTMLParserMode::HTML_BODY);
        $pdf->Output(sprintf('%s/app/card-%s.pdf', storage_path(), $card->id), Destination::FILE);

    }

    private function createBasePdf() {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $pdf = new Mpdf([
            'setAutoTopMargin' => 'stretch',
            'setAutoBottomMargin' => 'stretch',
            'fontDir' => array_merge($fontDirs, [
                base_path() . '/resources/fonts',
            ]),
            'fontdata' => $fontData + [
                    'street-cred' => [
                        'R' => 'street-cred.ttf'
                    ],
                    'eurostile' => [
                        'R' => 'eurostile-bold.ttf'
                    ]
                ],
        ]);
        return $pdf;
    }

    private function generateTable($tracks) {
        $table = "<table class='round-'>";
        $table .= "<tr><th>D</th><th>I</th><th>S</th><th>C</th><th>O</th></tr>";
        for ($i = 0; $i < 5; $i++) {
            $table .= "<tr>";
            for ($j = 0; $j < 5; $j++) {
                $idx = $i * 5 + $j;
                $track = <<<TRK
        <div class="artist">%s</div>
        <hr>
        <div class="song">%s</div>
        TRK;
                $track = sprintf($track, $tracks[$idx]->artist, $tracks[$idx]->song);


                if ($i === 2 && $j === 2) {
                    $img = base_path() . '/resources/assets/tkp.svg';
                    $track = "<img src='$img' />";
                }
                $table .= "<td>$track</td>";
            }
            $table .= "</tr>";

        }
        $table .= "</table>";

        return $table;
    }
}

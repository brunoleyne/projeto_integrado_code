<?php
/*
 * Calculo de Feriado
*/
namespace App\Helpers;

class Carbon extends \Carbon\Carbon {

    public function getHolidays( $year = null ) {
        if( $year === null) {
            $year = date('Y');
        }

        // Páscoa
        $pascoa = Carbon::createMidnightDate($year, 3, 21)->addDays(easter_days($year));

        // Segunda-Feira Carnaval
        $segundaCarnaval = $pascoa->copy()->subDay(48);

        // Terça-Feira Carnaval
        $tercaCarnaval = $pascoa->copy()->subDay(47);

        // Quarta-Feira Carnaval
        $quartaCarnaval = $pascoa->copy()->subDay(46);

        // Sexta-Feria Santa
        $sextaSanta = $pascoa->copy()->subDay(2);

        // Corpus Christi
        $corpusChristi = $pascoa->copy()->addDay(60);

        $holidays = array(
        	array(
                'name' => "Ano Novo",
                'date' => Carbon::create($year, 1, 1, 00),
                'id' => 1
            ),
            array(
                'name' => "Segunda-Feira Carnaval",
                'date' => $segundaCarnaval,
                'id' => 2
            ),
            array(
                'name' => "Terça-Feira Carnaval",
                'date' => $tercaCarnaval,
                'id' => 3
            ),
            array(
                'name' => "Quarta-Feira Carnaval",
                'date' => $quartaCarnaval,
                'id' => 4
            ),
            array(
                'name' => "Sexta-Feira Santa",
                'date' => $sextaSanta,
                'id' => 5
            ),
            array(
                'name' => "Páscoa",
                'date' => $pascoa,
                'id' => 2
            ),
            array(
                'name' => "Tiradentes",
                'date' => Carbon::create($year, 4, 21, 00),
                'id' => 6
            ),
            array(
                'name' => "Dia do Trabalhador",
                'date' => Carbon::create($year, 5, 1, 00),
                'id' => 6
            ),
            array(
                'name' => "Corpus Christi",
                'date' => $corpusChristi,
                'id' => 6
            ),
            array(
                'name' => "Assunção de Nossa Senhora",
                'date' => Carbon::create($year, 8, 15, 00),
                'id' => 6
            ),
            array(
                'name' => "Dia da Independência",
                'date' => Carbon::create($year, 9, 7, 00),
                'id' => 6
            ),
            array(
                'name' => "Nossa Senhora Aparecida",
                'date' => Carbon::create($year, 10, 12, 00),
                'id' => 6
            ),
            array(
                'name' => "Dia de Finados",
                'date' => Carbon::create($year, 11, 2, 00),
                'id' => 6
            ),
            array(
                'name' => "Proclamação da República",
                'date' => Carbon::create($year, 11, 15, 00),
                'id' => 6
            ),
            array(
                'name' => "Imaculada Conceição",
                'date' => Carbon::create($year, 12, 8, 00),
                'id' => 6
            ),
            array(
                'name' => "Natal",
                'date' => Carbon::create($year, 12, 25, 00),
                'id' => 6
            )
        );


        return $holidays;
    }

    public function isHoliday($year = null)
	{
        $year = $year ? $year : $this->year;
        $holidays = $this->getHolidays($year);
        $isHoliday = false;

        foreach ($holidays as $holiday) {
            if( $this->isBirthday($holiday['date']) ) {
                $isHoliday = true;
            }
        }

        return $isHoliday;
    }

    public function proximoDiaUtil()
    {
        return $this->addDays(1)->copy();
    }

}

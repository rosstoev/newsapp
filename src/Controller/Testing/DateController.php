<?php


namespace App\Controller\Testing;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DateController extends AbstractController
{

    /**
     * @Route("/testDate", name="test_date")
     */
    public function testDate(){
//       /* сегашна дата */
//        $date = new \DateTime();
//        $dateNow = $date->format('d.m.Y H:i:s');
//
//        /* предния месец */
//        $date = new \DateTime();
//        $lastMonth = $date->modify('last month')->format('d.m.Y');
//
//        /* предишна дата */
//        $date = new \DateTime();
//        $specificDate = $date->setDate(2012,02,24)->format('d.m.y');
//
//        /* последния четвъртък от предишния месец */
//        $date = new \DateTime();
//        $lastMonthSpecificDay = $date->modify("last Thursday of last Month")->format('d.m.y');
//
//        /* оставащи дни до определена дата */
//        $date = new \DateTime('now');
//        $dateInterval = $date->diff(new \DateTime('2020-10-06'));
//        $dateInterval = $dateInterval->format('%a days, %H hours, %m minutes');
//
//        /* датата в Нова Зеландия */
//        $date = new \DateTime();
//        $date->setTimezone(new \DateTimeZone('NZ'));
//        $newZealandDate = $date->format('d.m.Y H:i:s');
/*---------------------------------------------------------*/
        $dateTimeZone = new \DateTimeZone('Europe/Sofia');
        /* разлики в дати */
        function checkDate($firstDate, $secondDate){
            $date = new \DateTime($firstDate);
            $secondDate = new \DateTime($secondDate);
            $dateInterval = $date->diff($secondDate);
            if($dateInterval->i == 0 && $dateInterval->h == 0){
                    if($dateInterval-> m < 5){
                        return "Less than 5 minutes";
                    }
            }
            return "More than 5 minutes";

        }
        /* различни формати */
        $dateFormats = new \DateTime('now');
        /* на български */
        $newDate = new \DateTime('now');
        function bgDate(\DateTime $date){
            $bgMonths = ['Януари', 'Февруари', 'Март', 'Април', 'Май', 'Юни',
                        'Юли', 'Август', 'Септември', 'Октомври', 'Ноември', 'Декември'];
            $bgMonth = $bgMonths[intval($date->format('m'))-1];
            $day = $date->format('d');
            $year = $date->format('Y');

            return $day.' '.$bgMonth.' '.$year.' г.';
        }
        /* визуализация */
        dump($dateTimeZone->getLocation());

        dump(checkDate('now', 'today 13:05:0'));

        dump($dateFormats->format('G:i:s'));

        dump($dateFormats->format(DATE_ISO8601));

        dump(bgDate($newDate));
        exit;
    }
}
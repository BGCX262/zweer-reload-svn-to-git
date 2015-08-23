<?php

class Zwe_Weather_Moon
{
    const PHASE_0 = "New";
    const PHASE_1 = "Evening Crescent";
    const PHASE_2 = "First Quarter";
    const PHASE_3 = "Waxing Gibbous";
    const PHASE_4 = "Full";
    const PHASE_5 = "Waning Gibbous";
    const PHASE_6 = "Last Quarter";
    const PHASE_7 = "Morning Crescent";

    const ZODIAC_0 = 'Aries';
    const ZODIAC_1 = 'Taurus';
    const ZODIAC_2 = 'Gemini';
    const ZODIAC_3 = 'Cancer';
    const ZODIAC_4 = 'Leo';
    const ZODIAC_5 = 'Virgo';
    const ZODIAC_6 = 'Libra';
    const ZODIAC_7 = 'Scorpio';
    const ZODIAC_8 = 'Saggittarius';
    const ZODIAC_9 = 'Capricorn';
    const ZODIAC_10 = 'Aquarius';
    const ZODIAC_11 = 'Pisces';

    const PERIOD = 29.530588853;

    public static $Phases = array(self::PHASE_0, self::PHASE_1, self::PHASE_2, self::PHASE_3, self::PHASE_4, self::PHASE_5, self::PHASE_6, self::PHASE_7);
    public static $Zodiac = array(self::ZODIAC_0, self::ZODIAC_1, self::ZODIAC_2, self::ZODIAC_3, self::ZODIAC_4, self::ZODIAC_5, self::ZODIAC_6, self::ZODIAC_7, self::ZODIAC_8, self::ZODIAC_9, self::ZODIAC_10, self::ZODIAC_11);

    private $_day = 0;
    private $_month = 0;
    private $_year = 0;

    /**
     * @var int
     */
    private $_age;
    /**
     * @todo: still to implement
     * @var int
     */
    private $_illumination = null;
    /**
     * @var int
     */
    private $_phase = null;
    /**
     * @var int
     */
    private $_zodiac = null;

    private $_distance;
    private $_latitude;
    private $_longitude;

    public function __construct($day = null, $month = null, $year = null)
    {
        if(!isset($day))
            $day = date('d');
        if(!isset($month))
            $month = date('m');
        if(!isset($year))
            $year = date('Y');

        $this->_day = $day % (31 + 1);
        $this->_month = $month % (12 + 1);
        $this->_year = intval($year);

        $this->_calculate();
    }

    private function _calculate($state = 2)
    {
        $P2 = 2 * pi();

        $YY = $this->_year - intval((12 - $this->_month) / 10);
        $MM = $this->_month + 9;
        if($MM >= 12) $MM -= 12;

        $K1 = intval(365.25 * ($YY + 4712));
        $K2 = intval(30.6 * $MM + .5);
        $K3 = intval(intval(($YY / 100) + 49) * .75) - 38;

        # Julian date at 12h UT on day in question
        $J = $K1 + $K2 + $this->_day + 59;
        if($J > 2299160) $J -= $K3;

        # Calculate illumination (synodic) phase
        $IP = ($J - 2451550.1) / self::PERIOD;
        $IP -= intval($IP);
        if($IP < 0) $IP += 1;

        # Moon's age in days
        $AG = $IP * self::PERIOD;
        $this->_age = $AG;

        # Convert phase to radiant
        $IP *= $P2;

        # Calculate distance from anomalistic phase
        $DP = ($J - 2451562.2) / 27.55454988;
        $DP -= intval($DP);
        if($DP < 0) $DP += 1;
        $DP *= $P2;
        $this->_distance = 60.4 - 3.3 * cos($DP) - .6 * cos(2 * $IP - $DP) - .5 * cos(2 * $IP);

        # Calculate latitude from nodal (draconic) phase
        $NP = ($J - 2451565.2) / 27.212220817;
        $NP -= intval($NP);
        if($NP < 0) $NP += 1;

        # Convert to radians
        $NP *= $P2;
        $this->_latitude = 5.1 * sin($NP);

        # Calculate longitude from sidereal motion
        $RP = ($J - 2451555.8) / 27.321582241;
        $RP -= intval($RP);
        if($RP < 0) $RP+= 1;
        $this->_longitude = 360 * $RP + 6.3 * sin($DP) + 1.3 * sin(2 * $IP - $DP) + .7 * sin(2 * $IP);
    }

    public function getAge()
    {
        return $this->_age;
    }

    public function getPhase()
    {
        if(!isset($this->_phase))
        {
            # Phases from http://jivebay.com/2010/01/04/calculating-the-moon-phase-part-2/
            if($this->_age < 1.84566)
                $this->_phase = 0;
            elseif($this->_age < 5.53699)
                $this->_phase = 1;
            elseif($this->_age < 9.22831)
                $this->_phase = 2;
            elseif($this->_age < 12.91963)
                $this->_phase = 3;
            elseif($this->_age < 16.61096)
                $this->_phase = 4;
            elseif($this->_age < 20.30228)
                $this->_phase = 5;
            elseif($this->_age < 23.99361)
                $this->_phase = 6;
            elseif($this->_age < 27.68493)
                $this->_phase = 7;
            else
                $this->_phase = 0;
        }

        return $this->_phase;
    }

    public function getPhaseText()
    {
        return self::$Phases[$this->getPhase()];
    }

    public function getZodiac()
    {
        if(!isset($this->_zodiac))
        {
            if($this->_longitude < 33.18)
                $this->_zodiac = 11;
            elseif($this->_longitude < 51.16)
                $this->_zodiac = 0;
            elseif($this->_longitude < 93.44)
                $this->_zodiac = 1;
            elseif($this->_longitude < 119.48)
                $this->_zodiac = 2;
            elseif($this->_longitude < 135.30)
                $this->_zodiac = 3;
            elseif($this->_longitude < 173.34)
                $this->_zodiac = 4;
            elseif($this->_longitude < 224.17)
                $this->_zodiac = 5;
            elseif($this->_longitude < 242.57)
                $this->_zodiac = 6;
            elseif($this->_longitude < 51.16)
                $this->_zodiac = 7;
            elseif($this->_longitude < 271.26)
                $this->_zodiac = 8;
            elseif($this->_longitude < 302.49)
                $this->_zodiac = 9;
            elseif($this->_longitude < 311.72)
                $this->_zodiac = 10;
            elseif($this->_longitude < 348.58)
                $this->_zodiac = 11;
            else
                $this->_zodiac = 0;
        }

        return $this->_zodiac;
    }

    public function getZodiacText()
    {
        return self::$Zodiac[$this->getZodiac()];
    }

    public function getDistance()
    {
        return $this->_distance;
    }

    public function getLatitude()
    {
        return $this->_latitude;
    }

    public function getLongitude()
    {
        return $this->_longitude;
    }

    public function __toString()
    {
        return Zwe_Render::factory($this, array('viewScript' => 'weather/moon.phtml', 'scriptPath' => 'views/scripts/weather'))->render();
    }
}
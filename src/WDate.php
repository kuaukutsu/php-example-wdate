<?php

namespace kuaukutsu\ExampleWdate;

/**
 * Class WDate
 * @package kuaukutsu\ExampleWdate
 */
class WDate
{
    /**
     * @var string
     */
    private $year;

    /**
     * @var string
     */
    private $month;

    /**
     * @var string
     */
    private $day;

    /**
     * @var string
     */
    private $hour;

    /**
     * @var string
     */
    private $minute;

    /**
     * @var string
     */
    private $second;

    /**
     * @var \DateTimeImmutable
     */
    private $datetime;

    /**
     * WDate constructor.
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->parseStrToProperty($date);

        // validate
        if ($this->getDatetime() === false) {
            throw new WDateException();
        }
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return string
     */
    public function getHour(): string
    {
        return $this->hour;
    }

    /**
     * @return string
     */
    public function getMinute(): string
    {
        return $this->minute;
    }

    /**
     * @return string
     */
    public function getSecond(): string
    {
        return $this->second;
    }

    /**
     * @return bool|\DateTimeImmutable
     */
    public function getDatetime()
    {
        if ($this->datetime === null) {
            $this->datetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                sprintf('%s-%s-%s %s:%s:%s',
                    $this->year ?? date('Y'),
                    $this->month ?? date('m'),
                    $this->day ?? date('d'),
                    $this->hour ?? date('H'),
                    $this->minute ?? date('i'),
                    $this->second ?? date('s')
                )
            );
        }

        return $this->datetime;
    }

    /**
     * @param string $format
     * @return string
     */
    public function format(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->getDatetime()->format($format);
    }

    /**
     * @param WDate $other
     * @return int
     */
    public function howManyDaysBefore(self $other): int
    {
        $diff = $this->getDatetime()->diff($other->getDatetime());

        if ($diff->invert === 1) {
            throw new WDateException('The event has already passed');
        }

        return $diff->days;
    }

    /**
     * @param WDate $other
     * @return int
     */
    public function howManyDaysAfter(self $other): int
    {
        $diff = $this->getDatetime()->diff($other->getDatetime());

        if ($diff->invert === 0) {
            throw new WDateException('The event has not yet come');
        }

        return $diff->days;
    }

    /**
     * @param WDate $other
     * @return bool
     */
    public function isEqualTo(self $other): bool
    {
        return $this->format('U') === $other->format('U');
    }

    /**
     * @param $str
     */
    private function parseStrToProperty(string $str)
    {
        $params = explode(' ', $str);
        foreach ($params as $param) {

            /**
             * Parse time
             *
             * @comment
             * Если заменить \d на любой знак . , то в __construct будет корректная проверка валидности даты
             * Либо здесь можно сделать такой перебор как и для даты (нижу по коду)
             * Регулярка здесь скорее для примера.
             */
            if (preg_match('#(?P<hour>\d{2}):((?P<minute>\d{2}))?(:(?P<second>\d{2}))?#', $param, $match)) {

                if (isset($match['hour'])) {
                    $this->hour = $match['hour'];
                }

                if (isset($match['minute'])) {
                    $this->minute = $match['minute'];
                }

                if (isset($match['second'])) {
                    $this->second = $match['second'];
                }

            } else {

                // parse date
                $paramDate = explode('.', $param);
                if (count($paramDate) > 0) {
                    $this->year = sprintf("%'.04s", array_pop($paramDate));

                    if (count($paramDate) > 0) {
                        $this->month = sprintf("%'.02s", array_pop($paramDate));

                        if (count($paramDate) > 0) {
                            $this->day = sprintf("%'.02s", array_pop($paramDate));
                        }
                    }
                }
            }
        }
    }
}
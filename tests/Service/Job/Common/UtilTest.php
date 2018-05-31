<?php


namespace App\Tests\Service\Job\Common;
use App\Service\Job\Common\UtilTrait;


class UtilTest extends \PHPUnit_Framework_TestCase
{
    use UtilTrait;

    /**
     * @group wip
     */
    public function testGetAreaCodeFromName()
    {
        $input = [
            'A' => 'A',
            'A1'=> 'A1',
            'area A' => 'A',
            'Area A' => 'A',
            'ArEa A1' => 'A1',
            'Field 2' => 'F2',
            'CEM 1' => 'C1',
            'Inner/Outer Town' => 'IOT',
            'inner town' => 'IT',
            'area K1 North East' => 'K1N',
            'K South-West' => 'KSW',
            '2-Sounding A' => '2SA',
            'G.6002' => 'G6',
            '1b' => '1B',
            'Settore D1' => 'SD1',
            'North Field' => 'NF'
        ];

        foreach ($input as $name => $code)
        {
            $this->assertEquals($code, $this->getAreaCodeFromName($name));
        }
    }
}
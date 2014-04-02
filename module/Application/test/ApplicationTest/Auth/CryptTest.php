<?php
/**
 * Account Manager System (https://github.com/PsyduckMans/accountmanager)
 *
 * @link      https://github.com/PsyduckMans/accountmanager for the canonical source repository
 * @copyright Copyright (c) 2014 PsyduckMans (https://ninth.not-bad.org)
 * @license   https://github.com/PsyduckMans/accountmanager/blob/master/LICENSE MIT
 * @author    Psyduck.Mans
 */

namespace ApplicationTest\Auth;

/**
 * Class CryptTest
 * @package ApplicationTest\Auth
 */
class CryptTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var \ApplicationTest\Auth\Crypt
     */
    private $cryptGenerator;
    /**
     * setUp
     */
    protected function setUp()
    {
        parent::setUp();
        $this->cryptGenerator = \Bootstrap::getServiceManager()->get('Accountmanager\Auth\Crypt');
    }
    /**
     * tearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * testCreate
     *
     * @test \Application\Auth\Crypt::create
     */
    public function testCreate() {
        $exceptedPassword = 'J(*XE*(#!(9u3902';

        $hashPassword = $this->cryptGenerator->create($exceptedPassword);
        $hashLength = strlen($hashPassword);
        
        $this->assertInternalType('string', 'expect string');
        $this->assertGreaterThan(0, $hashLength, 'hash length should > 0') && $this->assertLessThanOrEqual(60, $hashLength, 'hash length should <= 60');
    }

    /**
     * testVerify
     *
     * @test \Application\Auth\Crypt::verify
     */
    public function testVerify() {
        $exceptedPassword = '=12~!@(f9887*Y*DS-+_**^Y&';

        $hashPassword = $this->cryptGenerator->create($exceptedPassword);
        $isVerify = $this->cryptGenerator->verify($exceptedPassword, $hashPassword);
        $this->assertInternalType('bool', $isVerify, 'expect bool type');
        $this->assertTrue($isVerify);

        $isVerify = $this->cryptGenerator->verify('UnMatchedPassword', $hashPassword);
        $this->assertInternalType('bool', $isVerify, 'expect bool type');
        $this->assertFalse($isVerify);
    }
}
 
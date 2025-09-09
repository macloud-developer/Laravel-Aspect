<?php

use Monolog\Logger;
use Ytake\LaravelAspect\Interceptor\AbstractLogger;

/**
 * AbstractLoggerのconvertLogLevelメソッドをテストするためのテストクラス
 */
class AbstractLoggerTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testConvertLogLevelWithIntegerConstants()
    {
        $logger = new TestableAbstractLogger();
        
        // Monolog定数からの変換をテスト
        $this->assertSame('debug', $logger->testConvertLogLevel(Logger::DEBUG));
        $this->assertSame('info', $logger->testConvertLogLevel(Logger::INFO));
        $this->assertSame('notice', $logger->testConvertLogLevel(Logger::NOTICE));
        $this->assertSame('warning', $logger->testConvertLogLevel(Logger::WARNING));
        $this->assertSame('error', $logger->testConvertLogLevel(Logger::ERROR));
        $this->assertSame('critical', $logger->testConvertLogLevel(Logger::CRITICAL));
        $this->assertSame('alert', $logger->testConvertLogLevel(Logger::ALERT));
        $this->assertSame('emergency', $logger->testConvertLogLevel(Logger::EMERGENCY));
    }

    public function testConvertLogLevelWithStringValues()
    {
        $logger = new TestableAbstractLogger();
        
        // 既に文字列の場合はそのまま返すことをテスト
        $this->assertSame('debug', $logger->testConvertLogLevel('debug'));
        $this->assertSame('info', $logger->testConvertLogLevel('info'));
        $this->assertSame('notice', $logger->testConvertLogLevel('notice'));
        $this->assertSame('warning', $logger->testConvertLogLevel('warning'));
        $this->assertSame('error', $logger->testConvertLogLevel('error'));
        $this->assertSame('critical', $logger->testConvertLogLevel('critical'));
        $this->assertSame('alert', $logger->testConvertLogLevel('alert'));
        $this->assertSame('emergency', $logger->testConvertLogLevel('emergency'));
    }

    public function testConvertLogLevelWithUnknownInteger()
    {
        $logger = new TestableAbstractLogger();
        
        // 未知の整数値の場合はデフォルトで'info'を返すことをテスト
        $this->assertSame('info', $logger->testConvertLogLevel(999));
        $this->assertSame('info', $logger->testConvertLogLevel(-1));
        $this->assertSame('info', $logger->testConvertLogLevel(0));
    }

    public function testConvertLogLevelWithUnknownString()
    {
        $logger = new TestableAbstractLogger();
        
        // 未知の文字列値の場合はそのまま返すことをテスト
        $this->assertSame('unknown', $logger->testConvertLogLevel('unknown'));
        $this->assertSame('custom', $logger->testConvertLogLevel('custom'));
    }
}

/**
 * AbstractLoggerのテスト用サブクラス
 */
class TestableAbstractLogger extends AbstractLogger
{
    /**
     * convertLogLevelメソッドをテスト可能にするためのパブリックラッパー
     */
    public function testConvertLogLevel($level): string
    {
        return $this->convertLogLevel($level);
    }
}
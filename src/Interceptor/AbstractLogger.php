<?php
declare(strict_types=1);

/**
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 *
 * Copyright (c) 2015-2020 Yuuki Takezawa
 *
 */

namespace Ytake\LaravelAspect\Interceptor;

use Psr\Log\LoggerInterface;
use Ray\Aop\MethodInvocation;
use Ytake\LaravelAspect\Annotation\LoggableAnnotate;

use function sprintf;

/**
 * Class AbstractLogger
 */
abstract class AbstractLogger
{
    /** @var string */
    protected $format = "%s:%s.%s";

    /** @var LoggerInterface */
    protected static $logger;

    /**
     * @param LoggableAnnotate $annotation
     * @param MethodInvocation $invocation
     * @return array
     * @throws \ReflectionException
     */
    protected function logFormatter(
        LoggableAnnotate $annotation,
        MethodInvocation $invocation
    ): array {
        $context = [];
        $arguments = $invocation->getArguments();
        foreach ($invocation->getMethod()->getParameters() as $parameter) {
            $context['args'][$parameter->name] = isset($arguments[$parameter->getPosition()]) ?
                $arguments[$parameter->getPosition()] :
                    ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null);
        }

        return [
            'level'   => $this->convertLogLevel($annotation->value),
            'message' => sprintf(
                $this->format,
                $annotation->name,
                $invocation->getMethod()->class,
                $invocation->getMethod()->name
            ),
            'context' => $context,
        ];
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        static::$logger = $logger;
    }

    /**
     * Convert Monolog log level integer constants to PSR-3 string levels
     * 
     * @param mixed $level
     * @return string
     */
    protected function convertLogLevel($level): string
    {
        if (is_string($level)) {
            return $level;
        }

        $levelMap = [
            100 => 'debug',    // Logger::DEBUG
            200 => 'info',     // Logger::INFO
            250 => 'notice',   // Logger::NOTICE
            300 => 'warning',  // Logger::WARNING
            400 => 'error',    // Logger::ERROR
            500 => 'critical', // Logger::CRITICAL
            550 => 'alert',    // Logger::ALERT
            600 => 'emergency' // Logger::EMERGENCY
        ];

        return $levelMap[$level] ?? 'info';
    }
}

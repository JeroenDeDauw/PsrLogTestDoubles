<?php

declare( strict_types = 1 );

namespace WMDE\PsrLogTestDoubles;

use Psr\Log\AbstractLogger;

/**
 * For psr/log 1.x
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LegacyLoggerSpy extends AbstractLogger {

	/**
	 * @var array<int, LogCall>
	 */
	private array $logCalls = [];

	public function log( $level, $message, array $context = [] ): void {
		$this->logCalls[] = new LogCall( $level, (string)$message, $context );
	}

	public function getLogCalls(): LogCalls {
		return new LogCalls( ...$this->logCalls );
	}

	public function getFirstLogCall(): ?LogCall {
		return $this->getLogCalls()->getFirstCall();
	}

	/**
	 * @throws AssertionException
	 */
	public function assertNoLoggingCallsWhereMade(): void {
		if ( !empty( $this->logCalls ) ) {
			throw new AssertionException(
				'Logger calls where made while non where expected: ' . var_export( $this->logCalls, true )
			);
		}
	}

}

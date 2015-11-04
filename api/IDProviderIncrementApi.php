<?php
class IDProviderIncrementApi extends ApiBase {

	/**
	 * Description of the allowed parameters
	 * @return array
	 */
	public function getAllowedParams() {

		$params = array(
			'prefix' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_HELP_MSG => 'idp-increment-prefix',
			),
			'padding' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 0,
				ApiBase::PARAM_HELP_MSG => 'idp-increment-padding',
			),
			'wikipage' => array(
				ApiBase::PARAM_TYPE => 'boolean',
			),
		);

		foreach ($params as $name => $value ) {
			$params[$name][ApiBase::PARAM_HELP_MSG] = "idp-increment-apiparam-$name";
		}

		return $params;
	}


	/**
	 * Calculate and return the response
	 */
	public function execute() {

		$id = null;
		$error = null;

		$params = $this->extractRequestParams();
		$prefix = $params['prefix'] ?: '';
		$padding = $params['padding'] ?: 0;


		try {
			$id = IDProviderFunctions::getIncrement($prefix, $padding);
		} catch (Exception $e) {
			$error = $e->getMessage();
		}

		// Build return array
		if ($id && !$error) {
			$this->getResult()->addValue( null, 'id', $id );
		} else {
			if (!$error) {
				$error = 'Unspecified error.';
			}
			$this->getResult()->addValue( null, 'error', $error );
		}
	}


	/**
	 * Some example queries
	 *
	 * @return array
	 */
	protected function getExamplesMessages() {
		return array(
			'action=idprovider-increment&padding=8' => 'idp-increment-example-1',
			'action=idprovider-increment&prefix=TestPrefix_&padding=5&wikipage=' => 'idp-increment-example-2'
		);
	}
}

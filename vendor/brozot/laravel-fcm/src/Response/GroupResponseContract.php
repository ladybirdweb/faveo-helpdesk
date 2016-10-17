<?php namespace LaravelFCM\Response;

/**
 * Interface GroupResponseContract
 *
 * @package LaravelFCM\Response
 */
interface GroupResponseContract {

	/**
	 * Get the number of device reached with success
	 * @return int
	 */
	public function numberSuccess();

	/**
	 * Get the number of device which thrown an error
	 *
	 * @return int
	 */
	public function numberFailure();

	/**
	 * Get all token in group that fcm cannot reach
	 *
	 * @return array
	 */
	public function tokensFailed();

}
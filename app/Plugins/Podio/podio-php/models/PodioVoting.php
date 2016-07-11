<?php
/**
 * @see https://developers.podio.com/doc/voting
 */
class PodioVoting extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/voting/get-result-of-voting-on-an-item-117727335
   */
  public static function get_result_for_item($item_id, $voting_id)
  {
      return Podio::get("/voting/item/{$item_id}/voting/{$voting_id}/result")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/voting/get-app-votings-117689723
   */
  public static function get_voting_id($app_id)
  {
      return Podio::get("/voting/app/{$app_id}/voting")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/voting/get-list-of-users-with-votes-117729546
   */
  public static function get_list_of_users_with_votes($item_id, $voting_id)
  {
      return Podio::get("/voting/item/{$item_id}/voting/{$voting_id}/user")->json_body();
  }
}

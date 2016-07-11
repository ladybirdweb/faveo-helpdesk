<?php
/**
 * @see https://developers.podio.com/doc/organizations
 */
class PodioOrganizationMember extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('admin', 'boolean');
        $this->property('employee', 'boolean');
        $this->property('space_memberships', 'integer');

        $this->has_one('profile', 'Contact');
        $this->has_one('user', 'User');
        $this->has_many('spaces', 'Space');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-member-50908
   */
  public static function get($org_id, $user_id)
  {
      return self::member(Podio::get("/org/{$org_id}/member/{$user_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/get-organization-members-50661
   */
  public static function get_for_org($org_id)
  {
      return self::listing(Podio::get("/org/{$org_id}/member/"));
  }

  /**
   * @see https://developers.podio.com/doc/organizations/end-organization-membership-50689
   */
  public static function delete($org_id, $user_id)
  {
      return Podio::delete("/org/{$org_id}/member/{$user_id}");
  }
}

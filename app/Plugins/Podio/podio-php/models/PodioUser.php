<?php
/**
 * @see https://developers.podio.com/doc/users
 */
class PodioUser extends PodioObject
{
    public function __construct($attributes = [])
    {
        $this->property('user_id', 'integer', ['id' => true]);
        $this->property('profile_id', 'integer');
        $this->property('name', 'string');
        $this->property('link', 'string');
        $this->property('avatar', 'integer');
        $this->property('mail', 'string');
        $this->property('status', 'string');
        $this->property('locale', 'string');
        $this->property('timezone', 'string');
        $this->property('flags', 'array');
        $this->property('type', 'string');
        $this->property('created_on', 'datetime');

        $this->has_one('profile', 'Contact');
        $this->has_many('mails', 'UserMail');

        $this->init($attributes);
    }

  /**
   * @see https://developers.podio.com/doc/users/get-user-22378
   */
  public static function get()
  {
      return self::member(Podio::get('/user'));
  }

  /**
   * @see https://developers.podio.com/doc/users/get-user-property-29798
   */
  public static function get_property($name)
  {
      return Podio::get("/user/property/{$name}")->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/users/set-user-property-29799
   */
  public static function set_property($name, $value)
  {
      return Podio::put("/user/property/{$name}", $value);
  }

  /**
   * @see https://developers.podio.com/doc/users/set-user-properties-9052829
   */
  public static function set_properties($attributes)
  {
      return Podio::put('/user/property/', $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/users/delete-user-property-29800
   */
  public static function delete_property($name)
  {
      return Podio::delete("/user/property/{$name}");
  }

  /**
   * @see https://developers.podio.com/doc/users/update-profile-22402
   */
  public static function update_profile($attributes)
  {
      return Podio::put('/user/profile/', $attributes);
  }

  /**
   * @see https://developers.podio.com/doc/users/get-profile-field-22380
   */
  public static function get_profile_field($field)
  {
      return Podio::get("/user/profile/{$field}")->json_body();
  }
}

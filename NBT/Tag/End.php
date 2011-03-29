<?php
/**
 * Description of End
 *
 * @author aheadley
 */
class NBT_Tag_End extends NBT_Tag_Finite {
  static protected $_tagType = NBT_Tag::TYPE_END;
  
  static public function getStructFormat() {
    return 'c';
  }

  static public function getByteCount() {
    return 1;
  }

  public function __construct() {
    $this->_data = "\0";
  }

  public function set( $value ) {
    throw new NBT_Tag_Exception( "End tags cannot have a value" );
  }
}

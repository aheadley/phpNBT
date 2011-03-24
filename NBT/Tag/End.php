<?php
/**
 * Description of End
 *
 * @author aheadley
 */
class NBT_Tag_End extends NBT_Tag {
  static protected $_tagType = NBT_Tag::TYPE_END;

  public function __construct() {
    $this->_data = "\0";
  }

  public function set( $value ) {
    throw new NBT_Tag_Exception( "End tags cannot have a value" );
  }

  public function out() {
    return $this->_data;
  }

  public function in( $data ) {
    if( $data !== $this->_data ) {
      throw new NBT_Tag_Exception( "Invalid data for end tag: {$data}" );
    }
  }
}

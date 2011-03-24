<?php
/**
 * Description of Byte
 *
 * @author aheadley
 */
class NBT_Tag_Byte extends NBT_Tag {
  static private $_tagType = NBT_Tag::TYPE_BYTE;
  
  public function set( $value ) {
    parent::set( $value );
  }

  public function in( $data ) {
    list(, $value) = unpack( $this->_getStructFormat(), $this->_getByteCount() );
    $this->set( $value );
  }

  public function out() {
    return pack( $this->_getStructFormat(), $this->get() );
  }

  protected function _getStructFormat() {
    return 'c';
  }

  protected function _getByteCount() {
    return 1;
  }
}

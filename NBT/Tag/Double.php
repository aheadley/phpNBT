<?php
/**
 * Description of Double
 *
 * @author aheadley
 */
class NBT_Tag_Double extends NBT_Tag_Float {
  static protected $_tagType  = NBT_Tag::TYPE_DOUBLE;

  static public function getStructFormat() {
    return 'd';
  }

  static public function getByteCount() {
    return 8;
  }

  public function set( $value ) {
    $this->_data = doubleval( $value );
  }
}

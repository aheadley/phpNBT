<?php
/**
 * Description of Int
 *
 * @author aheadley
 */

class NBT_Tag_Int extends NBT_FiniteTag {
  static protected $_tagType  = self::TYPE_INT;

  static public function getStructFormat() {
    return 'N';
  }

  static public function getByteCount() {
    return 4;
  }

  public function set( $value ) {
    $value = intval( $value );
    $this->_data = $value >= pow( 2, 31 ) ? $value - pow( 2, 32 ) : $value;
  }
}
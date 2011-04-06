<?php
/**
 * Description of Long
 *
 * @author aheadley
 */
class NBT_Tag_Long extends NBT_Tag {
  static protected $_tagType  = NBT_Tag::TYPE_LONG;

  static public function getByteCount() {
    return 8;
  }

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    $bytes = unpack( 'N2half', fread( $handle, self::getByteCount() ) );
    $value = gmp_add( $bytes['half2'], gmp_mul( $bytes['half1'], '4294967296' ) );
    if( gmp_cmp( $value, gmp_pow( 2, 63 ) ) >= 0 ) {
      $value = gmp_sub( $value, gmp_pow( 2, 64 ) );
    }
    return new NBT_Tag_Long( gmp_strval( $value ), $name );
  }

  public function get() {
    return gmp_strval( $this->_data );
  }

  public function set( $value ) {
    $this->_data = gmp_init( $value );
  }

  public function write( $handle ) {
    $second = gmp_mod( $this->_data, 2147483647);
    $first  = gmp_sub( $this->_data, $second );
    parent::write( $handle );
    if( !fwrite( $handle, pack( 'N2', $first, $second ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}

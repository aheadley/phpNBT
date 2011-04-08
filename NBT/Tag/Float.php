<?php
/**
 * Description of Float
 *
 * @author aheadley
 */
class NBT_Tag_Float extends NBT_FiniteTag {
  static protected $_tagType  = self::TYPE_FLOAT;

  static public function getStructFormat() {
    return 'f';
  }

  static public function getByteCount() {
    return 4;
  }

  static public function parse( $handle, $hasName = true ) {
    if( $hasName ) {
      $name = NBT_Tag_String::parse( $handle, false );
    } else {
      $name = null;
    }
    list(, $value ) = unpack( static::getStructFormat(),
      self::endianTransform( fread( $handle, static::getByteCount() ) ) );
    $tagClass = NBT_Tag::getTypeClass( static::$_tagType );
    return new $tagClass( $value, $name );
  }

  public function set( $value ) {
    $this->_data = floatval( $value );
  }

  public function write( $handle, $writeType = true ) {
    if( $writeType ) {
      parent::write( $handle, $writeTypes );
    }
    if( !fwrite( $handle, pack( static::getStructFormat(),
          self::endianTransform( $this->_data ) ) ) ) {
      throw new NBT_Tag_Exception( "Failed to write tag data: {$this->_data}" );
    }
  }
}

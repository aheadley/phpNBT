<?php
/**
 * Description of Compound
 *
 * @author aheadley
 */
class NBT_Tag_Compound extends NBT_Tag_Sequence {
  static private $_tagType = NBT_Tag::TYPE_COMPOUND;

  static public function parse( $handle ) {
    $tags = array();
    while( $newTagType = NBT_Tag_Byte::parse( $handle )->get() !== NBT_Tag::TYPE_END ) {
      $newTagClass = NBT_Tag::getTypeClass( $newTagType );
      $tags[] = $newTagClass::parse( $handle );
    }
  }

  public function __construct( array $data, $name = null ) {
    parent::__construct( $data, $name );
  }

  public function set( array $value ) {
    foreach( $value as $tag ) {
      if( !( $tag instanceof NBT_Tag ) ) {
        throw new NBT_Tag_Exception( 'NBT_Tag_Compound can only hold other NBT_Tag objects' );
      }
    }
    $this->_data = $value;
  }

  public function write( $handle ) {
    parent::write( $handle );
    foreach( $this->_data as $tag ) {
      $tag->write( $handle );
    }
  }
}

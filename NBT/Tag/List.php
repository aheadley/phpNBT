<?php
/**
 * Description of List
 *
 * @author aheadley
 */
class NBT_Tag_List extends NBT_SequenceTag {
  static private $_tagType  = NBT_Tag::TYPE_LIST;
  private $_containingType = null;

  public function __construct( $containingType, array $data, $name = null ) {
    parent::__construct( $data, $name );
    $this->_containingType = $containingType;
  }

  public function offsetExists( $offset ) {
    if( !is_int( $offset ) || $offset < 0 ) {
      return false;
    } else {
      return parent::offsetExists( $offset );
    }
  }

  public function offsetSet( $offset, NBT_Tag $value ) {
    if( $this->_containingType !== $value->getType() ) {
      throw new NBT_Tag_Exception( "Invalid tag type for tag list: " . get_class( $value ) );
    } elseif( !is_int( $offset ) || $offset < 0 ) {
      throw new NBT_Tag_Exception( "Invalid offset for tag list: {$offset}" );
    } else {
      parent::offsetSet( $offset, $value );
    }
  }

  public function set( array $value ) {
    foreach( $value as $tag ) {
      if( $this->_containingType !== $tag->getType() ) {
        throw new NBT_Tag_Exception( "Invalid tag type for tag list: " . get_class( $tag ) );
      }
    }
    $this->_data = $value;
  }
}

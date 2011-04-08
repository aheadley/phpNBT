<?php
/**
 * Description of Sequence
 *
 * @author aheadley
 */
abstract class NBT_SequenceTag extends NBT_Tag
  implements ArrayAccess, Countable, IteratorAggregate {

  public function __toString() {
    if( !is_null( $this->_name ) ) {
      return sprintf( '%s(%s:[%d])', get_class( $this ), $this->_name->get(),
        count( $this->get() ) );
    } else {
      return sprintf( '%s([%d])', get_class( $this ), count( $this->get() ) );
    }
  }

  public function count() {
    return count( $this->_data );
  }

  public function getIterator() {
    //TODO: make custom Tag iterator
    return new ArrayIterator( $this->_data );
  }

  public function offsetExists( $offset ) {
    return array_key_exists( $offset, $this->_data );
  }

  public function offsetGet( $offset ) {
    if( $this->offsetExists( $offset ) ) {
      return $this->_data[$offset];
    } else {
      var_dump( array_keys( $this->_data ) );
      throw new NBT_Tag_Exception( "Invalid offset: {$offset}" );
    }
  }

  public function offsetSet( $offset, $value ) {
    if( !( $value instanceof NBT_Tag ) ) {
      throw new NBT_Tag_Exception( "Invalid value type: {$value}" );
    } else {
      $this->_data[$offset] = $value;
    }
  }

  public function offsetUnset( $offset ) {
    if( $this->offsetExists( $offset ) ) {
      unset( $this->_data[$offset] );
    }
  }
}

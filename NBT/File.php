<?php
/**
 * Description of File
 *
 * @author aheadley
 */
class NBT_File {
  private $_data     = null;
  private $_filename = null;

  public function __construct( $filename ) {
    $this->_filename = $filename;
    if( file_exists( $filename ) ) {
      if( is_readable( $filename ) ) {
        $file = fopen( $filename, 'rb' );
        $data = fread( $file );
        if( $data === false ) {
          throw new NBT_Exception( "Failed to read file: {$this->_filename}" );
        } else {
          fclose( $file );
          $this->_data = new NBT_Data( $data );
        }
      } else {
        throw new NBT_Exception( "Unable to read file: {$this->_filename}" );
      }
    } else {
      $this->_data = new NBT_Data();
    }
  }

  public function write() {
    $file = fopen( $this->_filename, 'wb' );
    if( !fwrite( $file, $this->_data->out() ) ) {
      throw new NBT_File_Exception( "Failed to write file: {$this->_filename}" );
    }
    fclose( $file );
  }
}
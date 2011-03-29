<?php
/**
 * Description of File
 *
 * @author aheadley
 */
class NBT_File {
  private $_data      = null;
  private $_filename  = null;

  public function __construct( $filename ) {
    $this->_filename = $filename;
    if( file_exists( $filename ) ) {
      if( is_readable( $filename ) ) {
        $this->_load();
      } else {
        throw new NBT_Exception( "Unable to read file: {$this->_filename}" );
      }
    } else {
      $this->_data = new NBT_Data( null, NBT_Data::VERSION_GZIP );
    }
  }

  public function write( $filename = null ) {
    if( is_null( $filename ) ) {
      $filename = $this->_filename;
    }
    $file = fopen( $filename, 'wb' );
    if( !fwrite( $file, $this->_data->out() ) ) {
      throw new NBT_File_Exception( "Failed to write file: {$this->_filename}" );
    }
    fclose( $file );
  }

  protected function _load() {
    $this->_data = new NBT_Data(
      fopen( "compress.zlib://{$this->_filename}", 'rb' ),
        NBT_Data::VERSION_GZIP );
  }
}
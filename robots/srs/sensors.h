int read_gp2y0a_range(char value);
int bump(char pinBump);
unsigned char median_of_3( unsigned char  a, unsigned char b, unsigned char c );
extern decode_results results;
extern IRrecv irrecv;
void setupIrrecv();
unsigned int get_voltage(char index);

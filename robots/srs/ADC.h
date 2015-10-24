//ADC
#define FIRST_ADC_INPUT 0
#define LAST_ADC_INPUT 6

#define ADC_VREF_TYPE 0x40

void ADC_setup();
extern volatile unsigned int adc_data[LAST_ADC_INPUT-FIRST_ADC_INPUT+1];
extern volatile unsigned int sen_data[LAST_ADC_INPUT-FIRST_ADC_INPUT+1];
extern volatile unsigned char marker_sensor_is_ready[4];


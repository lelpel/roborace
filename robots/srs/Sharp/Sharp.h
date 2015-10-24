/**
 * @file VDC.h
 *
 * @brief
 */
#ifndef VDC_H 
#define VDC_H 


#ifndef WProgram_h
	#include	"WProgram.h"
#endif

/**
 * @class VEncoder
 *
 *This class contains the current state of encoder's counts.
 *
 * @author
 */
#define Vcc 5u  //напряжение питания цифровой части

// коэффициенты аналогового сигнала УЗ дальномера GP2D120
#define K (-1) // калиброванные коэффициенты ИК дальномера GP2D120
#define M 2914u
#define B 5u
#define AN 9.8/(1000*25.4)

// коэффициенты аналогового сигнала УЗ дальномера GP2D12
#define M1 6787u
#define B1 (-3)
#define K1 (-4)

// коэффициенты аналогового сигнала УЗ дальномера GP2Y0A02YK0F
#define M2 96810u
#define K2 (-29)
#define B2 1

// коэффициенты аналогового сигнала УЗ дальномера GP2Y0A21YK0F
#define M3 1024000u
#define K3 -1000u
#define B3 5.04*Vcc

enum IRType {GP2D120=0, GP2D12=1, GP2Y0A02YK0F=2, GP2Y0A21YK0F=3} ; // типы испольуемых датчиков


class VSharp
{
public:
	unsigned char m_port;
	IRType m_IRSensor;


	VSharp(const VSharp&);
	VSharp& operator=(const VSharp&);
public:
	
	VSharp(unsigned char port, IRType IRSensor);
	template <uint8_t width>
	int GetADCMedian();
	int SuperGauss();
	float GetDistanceIR();

};
template <uint8_t width>
int VSharp::GetADCMedian()
{
	int DataADC[width];
	    int temp;
	    for (uint8_t i = 0; i < width; ++i)
	        DataADC[i] = analogRead(m_port);
	    for (uint8_t i = 0;i < width; ++i)
	        for (uint8_t j = 0; j < width - 1; ++j)
	            if (DataADC[j + 1] < DataADC[j]) {
	                temp = DataADC[j];
	                DataADC[j] = DataADC[j + 1];
	                DataADC[j + 1] = temp;
	            }
	    return DataADC[width >> 1];

}
#endif

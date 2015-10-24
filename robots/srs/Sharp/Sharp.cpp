#include "Sharp.h"

VSharp::VSharp(unsigned char port, IRType IRSensor) :
		m_port(port),
		m_IRSensor(IRSensor)
{
	pinMode( m_port, INPUT);
}



int VSharp::SuperGauss()
{
int gauss[5];
for (int i=0;i<5;++i)
gauss[i]=GetADCMedian<5>();

return (((gauss[0]+gauss[4])>>4)+((gauss[1]+gauss[3])>>2)+3*((gauss[2]>>3)));

}


float VSharp::GetDistanceIR()// выдает расстояние до препятствия в ММ
{
float temp;
switch (m_IRSensor)
{
case(GP2D120):
{

temp=SuperGauss();
if (10*((M/(temp+B))+K)<300) {return (10*((M/(temp+B))+K));break;} else {return 300;break;}
}

case(GP2D12):
{
temp=SuperGauss();
if (10*((M1/(temp+B1))+K1)<500) {return (10*((M1/(temp+B1))+K1));break;} else {return 500;break;}
}

case(GP2Y0A02YK0F):
{
temp=SuperGauss();
if ((M2/(temp*B2+K2))<1000) {return (M2/(temp*B2+K2)) ;break;} else {return 1000;break;}
}

case(GP2Y0A21YK0F):
{
temp=SuperGauss();
if ((M3/(temp*B3+K3))<500) {return (M3/(temp*B3+K3)) ;break;} else {return 500;break;}
}
}
}




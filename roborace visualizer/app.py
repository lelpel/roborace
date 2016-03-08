""" Connect """
import time
import serial

# configure the serial connections
ser = serial.Serial(
    port='COM3',
    baudrate=115200,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS
)

ser.isOpen()

message = ['S', '1', '2', '3', '4', '5', '6', 'E']
#  list of message
messages = []

while 1:
    # let's wait one second
    time.sleep(4)

    # clear data
    data_received = []

    # read buffer
    while ser.inWaiting() > 0:
        data_received.append(ser.read(1))

    # analyze messages
    while len(data_received) > 8:
        # finde all mesages

        index_s = data_received.index(message[0])
        if data_received[index_s+len(message)-1] is message[len(message)-1]:
            index_e = index_s+len(message)-1
            print 'Find message'
            print index_s
            print index_e
            for el in data_received[index_s:index_e+1]:
                print ord(el)
            messages.append(data_received[index_s:index_e+1])
            del data_received[:index_e+1]
        else:
            del data_received[:index_s]
        # print messages

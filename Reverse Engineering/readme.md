# Brief Solution

## rev1
1. XOR strings array ```109;3#n<kl>9ilm;n9j9o`;nla<ooh>h;<<jh>%``` with the key and you will get the flag.
2. OR you can debugging to see the decrypted flag.

## rev2
1. Find `check::flag` function
2. In the function it will get inputs from users as array and put it in each variables
3. The variables then will be used in performing the array comparison.
4. I divide or split the inputs/flag into 4 variables.

## rev3
3 ways to solve:
1. XOR the flag byte with key, and rot13 it
2. Solve the crackme.
    - The first input, ask for password. We rot13 "cyx" for the password.
    - Second input, ask for passcode. Need to perform arithmetic. Below is the source code:
  ```
            int password = 0xaabbccdd; 
            int password2 = (password + 5) * 2 - 3;
            int password3 = (password2 >> 0xa) * 2 - 3;
            int password4 = sqrt(password3);
            int password5 = (int)(log(password4) / log(3));
            //printf("%d\n", password3 + password4 - password2 << password >> password5);
            if (pass == password3 + password4 - password2 << password >> password5)//8388608
  ```
  3. Patch the jump (require debugging)

## rev4
1. We XOR the shellcode with key, and create remote thread for the shellcode.
2. Extract the shellcode from the executable.
3. XOR the shellcode with key and save as bin
4. Throw the shellcode in scdbg.

## rev5
0. Contains function to resolve WinAPI during runtime
1. sleep for 1 hour
2. process injection with shellcode to popup messagebox (useless, just to distract player)
3. encrypted shellcode with multiple XOR for the flag messagebox
4. anti debugs
5. anti vmware, and virtualbox
6. check for username "ihack-admin"
7. check for any process name "explorer.exe", if have exit
8. bypass all these and extract the decrypted shellcode
9. debug shellcode and get the flag

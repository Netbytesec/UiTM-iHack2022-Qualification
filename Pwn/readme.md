# Brief Solution

## pwn1
1. Check file type, discover it is a python compiled binary.
2. Decompile binaruy using uncompyle6 to get source code.
3. Input function is used to take user input, it takes any user input as literal python coe.
4. Use python code to open flag.txt file such as: __import__('os').system("cat flag.txt")
## pwn2

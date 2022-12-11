This category was not release during the game. *As this question was not approved, hence it was not release during the event*

# Brief Solution

## MISC 1
- Do some python programming to convert from binary to image file
- Scan the QR code to get the flag

## MISC 2
- The file header is corrupted, fix it to get image file
- Opening the image will reveal encoded string with caesar in background, hence it was ROT13
- Decode the string to get the flag

## MISC 3
- Decode the string in the text file with this [decoder](https://enkhee-osiris.github.io/Decoder-JSFuck/)
- Make sure the version was 0.3.0 or it won't decode the string

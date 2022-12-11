#! /usr/bin/python2
import sys
print("Welcome to IHACK2022. \nThis python program will calculate the prime numbers up to a given number.\nPlease enter a number to be calculated.")
sys.stdout.flush()
number = input("")
sys.stdout.flush()
number = int(number)

def is_prime(number):
  if number <= 1:
    return False
  for i in range(2, number):
    if number % i == 0:
      return False
  return True

def print_primes(number):
  for i in range(1, number+1):
    if is_prime(i):
      print(i)


print("The prime numbers up to", number, "are:")
sys.stdout.flush()
print_primes(number)

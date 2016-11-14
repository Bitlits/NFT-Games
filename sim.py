import random

for y in range(0,1000):
	bank = 50
	winnings = 0
	site = 0
	count = 0
	maxJack = 0
	for x in range(0,100000):
		one = random.randrange(10)
		two = random.randrange(10)
		thr = random.randrange(10)
		fou = random.randrange(10)
		fiv = random.randrange(10)

		bank += .09
		site += .01

		if one==7 and two==7 and thr==7 and fou==7 and fiv==7:
			payment = bank / 2.
		elif ((one==7 and two==7 and thr==7 and fou==7)
			or (two==7 and thr==7 and fou==7 and fiv==7)):
			payment = 10
		elif ((one==7 and two==7 and thr==7)
			or (two==7 and thr==7 and fou==7)
			or (thr==7 and fou==7 and fiv==7)):
			payment = 5
		elif ((one==7 and two==7)
			or (two==7 and thr==7)
			or (thr==7 and fou==7)
			or (fou==7 and fiv==7)):
			payment = 1
		elif one==7 or two==7 or thr==7 or fou==7 or fiv==7:
			payment = .1
		else:
			payment = 0

		bank -= payment
		winnings += payment
		if bank / 2. > maxJack:
			maxJack = bank / 2.
		if payment > 0:
			count += 1
			# print str(x) + ": Bank: " + str(bank) + " | Winnings: " + str(winnings) + " | Slots: " + str(one) + str(two) + str(thr) + str(fou) + str(fiv)
		if bank <= 0:
			print "Broke the bank"
			break

	print "Site: " + str(site) + " | Total Wins: " + str(count) + " | Bank: " + str(bank) + " | Winnings: " + str(winnings) + " | Max Jack: " + str(maxJack)

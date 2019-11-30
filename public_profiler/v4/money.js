// Sum Cash
function sumCash()
{
    ZeroFill(sheet()["CashAD"]);
    ZeroFill(sheet()["CashPP"]);
	ZeroFill(sheet()["CashGP"]);
	ZeroFill(sheet()["CashSP"]);
	ZeroFill(sheet()["CashCP"]);

	var total = 0;
    total += (parseInt(sheet()["CashAD"].value) * 10000);
    total += (parseInt(sheet()["CashPP"].value) * 100);
	total += (parseInt(sheet()["CashGP"].value));
	total += (parseInt(sheet()["CashSP"].value) / 10);
	total += (parseInt(sheet()["CashCP"].value) / 100);

	total *= 100;
	total = Math.round(total);
	total /= 100;

	sheet()["CashTotal"].value = total;

    ZeroFill(sheet()["PartyCashAD"]);
    ZeroFill(sheet()["PartyCashPP"]);
	ZeroFill(sheet()["PartyCashGP"]);
	ZeroFill(sheet()["PartyCashSP"]);
	ZeroFill(sheet()["PartyCashCP"]);

	total = 0;
    total += (parseInt(sheet()["PartyCashAD"].value) * 10000);
    total += (parseInt(sheet()["PartyCashPP"].value) * 100);
	total += (parseInt(sheet()["PartyCashGP"].value));
	total += (parseInt(sheet()["PartyCashSP"].value) / 10);
	total += (parseInt(sheet()["PartyCashCP"].value) / 100);

	total *= 100;
	total = Math.round(total);
	total /= 100;

	sheet()["PartyCashTotal"].value = total;
}

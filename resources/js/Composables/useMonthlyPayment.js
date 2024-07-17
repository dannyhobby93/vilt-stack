import { computed, isRef } from "vue";

export const useMonthlyPayment = (inpTotal, inpInterestRate, inpDuration) => {
    const total = isRef(inpTotal) ? inpTotal.value : inpTotal;
    const interestRate = isRef(inpInterestRate)
        ? inpInterestRate.value
        : inpInterestRate;
    const duration = isRef(inpDuration) ? inpDuration.value : inpDuration;

    const monthlyPayment = computed(() => {
        const principle = total;
        const monthlyInterest = interestRate / 100 / 12;
        const numberOfPaymentMonths = duration * 12;

        return (
            (principle *
                monthlyInterest *
                Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) /
            (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
        );
    });

    const totalPaid = computed(() => {
        return duration * 12 * monthlyPayment.value;
    });

    const totalInterest = computed(() => totalPaid.value - total);

    return { monthlyPayment, totalPaid, totalInterest };
};

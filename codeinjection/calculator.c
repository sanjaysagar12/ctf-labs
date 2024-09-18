#include <stdio.h>
#include <stdlib.h>

int main(int argc, char *argv[]) {
    if (argc != 4) {
        printf("Usage: %s <number1> <operator> <number2>\n", argv[0]);
        return 1;
    }

    // Convert the first and third arguments to integers
    int num1 = atoi(argv[1]);
    int num2 = atoi(argv[3]);
    char operator = argv[2][0];  // Get the operator (should be +, -, *, or /)

    int result;

    // Perform the operation based on the operator
    switch (operator) {
        case '+':
            result = num1 + num2;
            break;
        case '-':
            result = num1 - num2;
            break;
        case '*':
            result = num1 * num2;
            break;
        case '/':
            if (num2 == 0) {
                printf("Error: Division by zero is not allowed.\n");
                return 1;
            }
            result = num1 / num2;
            break;
        default:
            printf("Error: Unsupported operator. Use +, -, *, or /.\n");
            return 1;
    }

    // Output the result
    printf("Result: %d\n", result);

    return 0;
}

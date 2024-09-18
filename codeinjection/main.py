from flask import Flask, request, jsonify
import subprocess
import re
app = Flask(__name__)


# Route to handle the math operation
@app.route('/hello', methods=['GET'])
def HelloWorld():
    return jsonify({"data":"Hello World"})

# Route to handle the math operation
@app.route('/get-calculate', methods=['GET'])
def calculate_get():
    # Get the parameters from the query string
    num1 = request.args.get('num1')
    operator = request.args.get('operator')
    num2 = request.args.get('num2')
    
    if not re.match("^[+\-*/]+$",operator):
        return jsonify({'error': str("invalid")}), 500
    if not re.match(r'^\d+$',num1):
            return jsonify({'error': str("invalid")}), 500
    if not re.match(r'^\d+$',num2):
            return jsonify({'error': str("invalid")}), 500

    # Check if all parameters are provided
    if not num1 or not operator or not num2:
        return jsonify({'error': 'Missing parameters. Usage: /calculate?num1=1&operator=+&num2=3'}), 400

    try:
        # Construct the command
        command = f"./calculator {num1} {operator} {num2}"
        print(f"Executing: {command}")
        
        # Use subprocess.check_output to capture the result
        result = subprocess.check_output(command, shell=True, text=True)
        
        # Strip any whitespace or newlines from the result
        result = result.strip()
        
        return jsonify({'result': result})
    except subprocess.CalledProcessError as e:
        return jsonify({'error': str(e)}), 500
    except Exception as e:
        return jsonify({'error': str(e)}), 500


@app.route('/post-calculate', methods=['POST'])
def calculate_post():
    # Get the parameters from the JSON body
    data = request.json
    num1 = data.get('num1')
    operator = data.get('operator')
    num2 = data.get('num2')
    
    # Check if all parameters are provided
    if not num1 or not operator or not num2:
        return jsonify({'error': 'Missing parameters. Required: num1, operator, num2'}), 400

    try:
        # Construct the command
        command = f"./calculator {num1} {operator} {num2}"
        print(f"Executing: {command}")
        
        # Use subprocess.check_output to capture the result
        result = subprocess.check_output(command, shell=True, text=True)
        
        # Strip any whitespace or newlines from the result
        result = result.strip()
        
        return jsonify({'result': result})
    except subprocess.CalledProcessError as e:
        return jsonify({'error': str(e)}), 500
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
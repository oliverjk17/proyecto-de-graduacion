from flask import Flask, render_template, request, redirect, url_for 

app = Flask(__name__)

# Página KPI
@app.route('/')
def kpi():
    return render_template('kpi.html')

# Ruta para recibir la respuesta del usuario
@app.route('/submit', methods=['POST'])
def submit():
    if request.method == 'POST':
        satisfaction = request.form.get('satisfaction')
        
        # Aquí puedes guardar la selección o procesarla para generar métricas
        print(f"Satisfacción seleccionada: {satisfaction}")
        
        return redirect(url_for('kpi'))  # Redireccionar de nuevo a la página principal

if __name__ == "__main__":
    app.run(debug=True)

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fusion</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/css/adminlte.min.css">

  <link rel="stylesheet" href="/assets/css/customcss.css">

  <style>
    canvas {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      z-index: 2;
    }

    .card {
      z-index: 3;
    }
  </style>
</head>

<body>
  <canvas></canvas>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-white box">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <div class="card-header text-center fw-bold mb-2">
                  <a href="../../index2.html" class="h1"><b>Fusion</b></a>
                </div>

                <p class="text-white-50 mb-5" style="color: white">Please enter your login and password!</p>

                @error('email')
                  <p class="login-box-msg">{{ $errors->get('email')[0] }}</p>
                @enderror
                <form action="{{ route('login_process') }}" method="post">
                  @csrf
                  <div class="form-outline form-white mb-4">
                    <input name="email" type="email" id="typeEmailX"
                      class="form-control form-control-lg button-save" />
                    <label class="form-label" for="typeEmailX" style="color: white">Email</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input name="password" type="password" id="typePasswordX"
                      class="form-control form-control-lg button-save" />
                    <label class="form-label" for="typePasswordX" style="color: white">Password</label>
                  </div>
                  <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                  <button class="btn btn-light btn-lg px-5 button-save" type="submit">Login</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- jQuery -->
  <script src="/assets/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/js/adminlte.min.js"></script>

  <script>
    var canvas = document.createElement("canvas");
    var width = canvas.width = window.innerWidth * 0.75;
    var height = canvas.height = window.innerHeight * 0.75;
    document.body.appendChild(canvas);
    var gl = canvas.getContext('webgl');

    var mouse = {
      x: 0,
      y: 0
    };

    var numMetaballs = 30;
    var metaballs = [];

    for (var i = 0; i < numMetaballs; i++) {
      var radius = Math.random() * 60 + 10;
      metaballs.push({
        x: Math.random() * (width - 2 * radius) + radius,
        y: Math.random() * (height - 2 * radius) + radius,
        vx: (Math.random() - 0.5) * 3,
        vy: (Math.random() - 0.5) * 3,
        r: radius * 0.75
      });
    }

    var vertexShaderSrc = `
    attribute vec2 position;

    void main() {
    // position specifies only x and y.
    // We set z to be 0.0, and w to be 1.0
    gl_Position = vec4(position, 0.0, 1.0);
    }
    `;

    var fragmentShaderSrc = `
    precision highp float;

    const float WIDTH = ` + (width >> 0) + `.0;
    const float HEIGHT = ` + (height >> 0) + `.0;

    uniform vec3 metaballs[` + numMetaballs + `];

    void main(){
    float x = gl_FragCoord.x;
    float y = gl_FragCoord.y;

    float sum = 0.0;
    for (int i = 0; i < ` + numMetaballs + `; i++) {
    vec3 metaball = metaballs[i];
    float dx = metaball.x - x;
    float dy = metaball.y - y;
    float radius = metaball.z;

    sum += (radius * radius) / (dx * dx + dy * dy);
    }

    if (sum >= 0.99) {
    gl_FragColor = vec4(mix(vec3(x / WIDTH, y / HEIGHT, 1.0), vec3(0, 0, 0), max(0.0, 1.0 - (sum - 0.99) * 100.0)), 1.0);
    return;
    }

    gl_FragColor = vec4(0.0, 0.0, 0.0, 1.0);
    }

    `;

    var vertexShader = compileShader(vertexShaderSrc, gl.VERTEX_SHADER);
    var fragmentShader = compileShader(fragmentShaderSrc, gl.FRAGMENT_SHADER);

    var program = gl.createProgram();
    gl.attachShader(program, vertexShader);
    gl.attachShader(program, fragmentShader);
    gl.linkProgram(program);
    gl.useProgram(program);

    var vertexData = new Float32Array([
      -1.0, 1.0,
      -1.0, -1.0,
      1.0, 1.0,
      1.0, -1.0,
    ]);
    var vertexDataBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, vertexDataBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, vertexData, gl.STATIC_DRAW);

    var positionHandle = getAttribLocation(program, 'position');
    gl.enableVertexAttribArray(positionHandle);
    gl.vertexAttribPointer(positionHandle,
      2,
      gl.FLOAT,
      gl.FALSE,
      2 * 4,
      0
    );

    var metaballsHandle = getUniformLocation(program, 'metaballs');

    loop();

    function loop() {
      for (var i = 0; i < numMetaballs; i++) {
        var metaball = metaballs[i];
        metaball.x += metaball.vx;
        metaball.y += metaball.vy;
        if (metaball.x < metaball.r || metaball.x > width - metaball.r) metaball.vx *= -1;
        if (metaball.y < metaball.r || metaball.y > height - metaball.r) metaball.vy *= -1;
      }

      var dataToSendToGPU = new Float32Array(3 * numMetaballs);
      for (var i = 0; i < numMetaballs; i++) {
        var baseIndex = 3 * i;
        var mb = metaballs[i];
        dataToSendToGPU[baseIndex + 0] = mb.x;
        dataToSendToGPU[baseIndex + 1] = mb.y;
        dataToSendToGPU[baseIndex + 2] = mb.r;
      }
      gl.uniform3fv(metaballsHandle, dataToSendToGPU);

      gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);

      requestAnimationFrame(loop);
    }

    function compileShader(shaderSource, shaderType) {
      var shader = gl.createShader(shaderType);
      gl.shaderSource(shader, shaderSource);
      gl.compileShader(shader);

      if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        throw "Shader compile failed with: " + gl.getShaderInfoLog(shader);
      }
      return shader;
    }

    function getUniformLocation(program, name) {
      var uniformLocation = gl.getUniformLocation(program, name);
      if (uniformLocation === -1) {
        throw 'Can not find uniform ' + name + '.';
      }
      return uniformLocation;
    }

    function getAttribLocation(program, name) {
      var attributeLocation = gl.getAttribLocation(program, name);
      if (attributeLocation === -1) {
        throw 'Can not find attribute ' + name + '.';
      }
      return attributeLocation;
    }

    canvas.onmousemove = function(e) {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    }
  </script>

</body>

</html>

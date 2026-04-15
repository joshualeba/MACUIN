from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from data import db as database
from routers import auth_router, product_router, report_router
from security.auth_handler import hash_password

# Inicialización de la base de datos (crea las tablas si no existen)
database.Base.metadata.create_all(bind=database.engine)

# Migración segura: añade columnas nuevas a tablas existentes sin borrar datos
def run_migrations():
    try:
        with database.engine.connect() as conn:
            # Verificar si la columna 'telefono' ya existe en la tabla 'users'
            result = conn.execute(database.text("PRAGMA table_info(users)"))
            columns = [row[1] for row in result.fetchall()]

            if "telefono" not in columns:
                conn.execute(database.text("ALTER TABLE users ADD COLUMN telefono TEXT DEFAULT 'N/A'"))
                conn.commit()
                print("MIGRACIÓN: columna 'telefono' añadida a la tabla 'users'.")
            else:
                print("MIGRACIÓN: columna 'telefono' ya existe, sin cambios.")
    except Exception as e:
        print(f"Error en migración: {e}")

run_migrations()

# Semillero de administrador predeterminado con manejo de errores
def seed_admin():
    try:
        db = database.SessionLocal()
        admin_email = "Joshualeba2109@gmail.com".lower()
        admin_exists = db.query(database.User).filter(database.User.email == admin_email).first()
        if not admin_exists:
            print(f"SEMBRANDO ADMINISTRADOR: {admin_email}")
            admin_user = database.User(
                nombre="Joshua León",
                email=admin_email,
                password=hash_password("Admin123!"),
                is_active=True,
                role="Super admin",
                estado_ciudad="N/A"
            )
            db.add(admin_user)
            db.commit()
            print("ADMINISTRADOR SEMBRADO CON ÉXITO")
        db.close()
    except Exception as e:
        print(f"Advertencia al sembrar administrador: {str(e)}")

def seed_products():
    try:
        db = database.SessionLocal()
        count = db.query(database.Product).count()
        if count == 0:
            print("SEMBRANDO PRODUCTOS INICIALES")
            productos_data = [
                {"nombre": "Amortiguador de gas premium", "precio": "1450", "stock": 15, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/1_mum70h.jpg", "desc_breve": "Vuelve tu auto estable ante los baches y elimina el balanceo por completo.", "desc_completa": "Diseñado y desarrollado bajo los más estrictos estándares de la industria, este componente restaura la eficiencia y seguridad total de tu vehículo. Gracias a su maquinado de precisión y control de calidad superior (OEM), ofrece un ensamble directo e impecable.", "cat": "suspension", "active": True},
                {"nombre": "Batería automotriz 12V LTH", "precio": "2300", "stock": 45, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803604/2_gv1kb4.jpg", "desc_breve": "Arranque seguro bajo cualquier clima con celdas de alta duración.", "desc_completa": "Esta batería automotriz asegura un arranque de motor infalible mediante celdas con tecnología de punta diseñadas para operar a la perfección bajo condiciones extremas de frío o calor.", "cat": "electrico", "active": True},
                {"nombre": "Llanta deportiva de alto rendimiento", "precio": "1850", "stock": 3, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/3_jhe3ti.jpg", "desc_breve": "Maximiza el agarre y la tracción en cualquier condición de pista o lluvia.", "desc_completa": "Componente fundamental para un rodaje seguro y estable a altas velocidades. Con su avanzada banda de rodadura direccional, evacúa el agua instantáneamente y reduce significativamente la distancia de frenado.", "cat": "suspension", "active": True},
                {"nombre": "Filtro de aceite sintético", "precio": "250", "stock": 12, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/4_rejzkf.jpg", "desc_breve": "Atrapa hasta el 99% de las partículas contaminantes del motor.", "desc_completa": "Filtro de calidad suprema reforzado con medio filtrante sintético de gran volumen. Proporciona máxima protección contra el desgaste prematuro de las piezas del motor.", "cat": "motor", "active": True},
                {"nombre": "Juego de balatas cerámicas", "precio": "750", "stock": 25, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/5_xqmuur.jpg", "desc_breve": "Frenado silencioso, libre de asbesto y ultra seguro.", "desc_completa": "Las balatas cerámicas disipan el calor de forma muy rápida y no generan ese polvo negro indeseado en tus rines. Brindan un frenado de pánico eficiente sin rechinar.", "cat": "frenos", "active": True},
                {"nombre": "Faros LED de largo alcance", "precio": "1200", "stock": 8, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803611/6_wcpptk.jpg", "desc_breve": "Iluminación nítida con más de 10,000 lúmenes de potencia para carretera.", "desc_completa": "Kit de luces principales de tecnología LED. Ofrecen un rayo de luz concentrado para manejar por la noche con extraordinaria visibilidad en la carretera sin deslumbrar a otros conductores.", "cat": "electrico", "active": True},
                {"nombre": "Radiador de aluminio reforzado", "precio": "2100", "stock": 5, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/7_nrnjsu.jpg", "desc_breve": "Sistema de enfriamiento superior para prevenir sobrecalentamientos.", "desc_completa": "Construido con aluminio billet de soldadura TIG, este radiador maximiza el área de contacto para mantener tu motor en la temperatura ideal y alargar su vida útil.", "cat": "motor", "active": True},
                {"nombre": "Bomba de agua de alto flujo", "precio": "850", "stock": 18, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803601/8_djl9tm.jpg", "desc_breve": "Mantiene un flujo constante y óptimo del refrigerante.", "desc_completa": "Equipada con un sello interno modificado y aspas contorneadas, garantiza que la circulación del anticongelante prevenga burbujas de aire o excesos tórmicos.", "cat": "motor", "active": True},
                {"nombre": "Kit de distribución completo", "precio": "3400", "stock": 2, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803605/9_o22arl.jpg", "desc_breve": "Sincronización perfecta del motor, incluye banda, tensor y polea.", "desc_completa": "Este equipo previene rupturas de banda que pueden ser catastróficas para las válvulas de tu auto. Incluye todos los implementos rodantes para una reparación integral y duradera.", "cat": "motor", "active": True},
                {"nombre": "Sensor de oxígeno Denso", "precio": "950", "stock": 10, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/10_xqowdm.jpg", "desc_breve": "Optimiza el consumo de combustible midiendo la mezcla de gases.", "desc_completa": "Componente eléctrico preciso que indica al actuador la cantidad de combustible a inyectar al instante. Esto repercute en un considerable ahorro y reduce las emisiones contaminantes.", "cat": "electrico", "active": True},
                {"nombre": "Inyector de combustible 4 puertos", "precio": "1100", "stock": 15, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803583/11_n3roer.jpg", "desc_breve": "Pulverización exacta para aprovechar cada gota de gasolina.", "desc_completa": "Con una bobina de baja resistencia y patrón de spray atomizado cónico, recupera la aceleración briosa de fábrica de tu automóvil resolviendo arranques difíciles.", "cat": "motor", "active": True},
                {"nombre": "Bobina de encendido", "precio": "600", "stock": 30, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/12_dbimni.jpg", "desc_breve": "Proporciona la chispa con voltaje ideal para la ignición.", "desc_completa": "Un indispensable para convertir los 12 voltios en la alta tensión requerida para prender la chispa entre los electrodos. Su encapsulado es resistente al agrietamiento.", "cat": "electrico", "active": True},
                {"nombre": "Bujía láser de Iridio", "precio": "250", "stock": 100, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803615/13_q15jp9.jpg", "desc_breve": "Encendido instantáneo y ahorro de combustible con punta fina.", "desc_completa": "La mejor aleación disponible que asegura los más largos lapsos preventivos del mercado. Mínimo desgaste de la punta de electrodo permitiendo una combustión muy limpia.", "cat": "electrico", "active": True},
                {"nombre": "Alternador 12V", "precio": "2800", "stock": 4, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803612/14_cx1b8o.jpg", "desc_breve": "Generador de energía probado para abastecer todos los accesorios eléctricos.", "desc_completa": "Reconstruido bajo métodos certificados, proporciona la energía adecuada constante sin fluctuar, recargando tu sistema al unísono para proteger fusibles y tableros inteligentes.", "cat": "electrico", "active": True},
                {"nombre": "Marcha de arranque", "precio": "1900", "stock": 7, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803600/15_ojqtbz.jpg", "desc_breve": "Engrane preciso y potente para iniciar tu motor suavemente.", "desc_completa": "Este arrancador tipo reducción de engranaje cuenta con un imán permanente resistente. Esto se traduce en más potencia al arrancar con mucho menor drenaje de la batería.", "cat": "electrico", "active": True},
                {"nombre": "Compresor A/C", "precio": "3600", "stock": 3, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803605/16_jfkbtw.jpg", "desc_breve": "Refrigera tu cabina al instante incluso en días extremadamente soleados.", "desc_completa": "Completamente lubricado con un embrague con baleros importados. Suprime los ruidos desgastantes al circular el gas freón, retornando el clima agradable para el conductor y pasajeros.", "cat": "motor", "active": True},
                {"nombre": "Condensador A/C", "precio": "1400", "stock": 8, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803610/17_lele1h.jpg", "desc_breve": "Disipa el calor del refrigerante de manera altamente eficiente.", "desc_completa": "Radiador de aire acondicionado con aletas multipunto a prueba de abolladuras ligeras, su aleación de zinc y aluminio impide su ruptura de tuberías con la vibración constante.", "cat": "motor", "active": True},
                {"nombre": "Filtro de aire alto flujo", "precio": "550", "stock": 20, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/18_iohp0d.jpg", "desc_breve": "Cónico y lavable, otorga caballos de fuerza y sonido deportivo.", "desc_completa": "Con malla corrugada de soporte superior, este componente incrementa hasta un 25% la aspiración fluida de la cámara de ignición. Su re-uso ahorra decenas de recambios.", "cat": "motor", "active": True},
                {"nombre": "Filtro de cabina carbón", "precio": "350", "stock": 35, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803587/19_arzsz1.jpg", "desc_breve": "Respira aire purificado bloqueando humo y olores.", "desc_completa": "Utiliza carbón activado para adsorber sustancias perjudiciales, gases estancados del escape y alérgenos microscópicos introducidos desde la ventilación del parabrisas.", "cat": "motor", "active": True},
                {"nombre": "Embrague completo", "precio": "2900", "stock": 5, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803588/20_zgaqnp.jpg", "desc_breve": "Cambios de velocidad precisos y suaves como nuevo.", "desc_completa": "Kit original que soluciona los temblores molestos y la fricción tardía. Se trata del puente de fuerza óptima entre tu eje y la flecha manual evitando tirones en las pendientes.", "cat": "motor", "active": True},
                {"nombre": "Bomba gasolina eléctrica", "precio": "1250", "stock": 12, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/21_g4odld.jpg", "desc_breve": "Entrega constante y silenciosa de presión al riel.", "desc_completa": "Impulsor mejorado que evita la formación de vacíos. Es muy recomendada en climas muy variados ya que sella los filamentos expuestos protegiéndolos de sedimentos de hidrocarburo.", "cat": "motor", "active": True},
                {"nombre": "Rótula de suspensión", "precio": "480", "stock": 22, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803562/22_riq9wk.jpg", "desc_breve": "Soporta movimientos bruscos manteniendo firme la dirección.", "desc_completa": "Unión esencial entre horquilla y mangueta con perno de tratamiento de alto pulido. Elimina rechinidos al girar en estacionamientos y prolonga la vida recta de tus neumáticos.", "cat": "suspension", "active": True},
                {"nombre": "Terminal de dirección", "precio": "320", "stock": 16, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803609/23_gzgzka.jpg", "desc_breve": "Protege la alineación de tu auto frente a baches.", "desc_completa": "Extremo crucial diseñado con casquillos internos recubiertos de acetal. Protege firmemente los brazos mecánicos manteniendo el volante calibrado ante topes y agujeros.", "cat": "suspension", "active": True},
                {"nombre": "Tornillo estabilizador", "precio": "250", "stock": 28, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803609/24_rak6t6.jpg", "desc_breve": "Conecta la barra estabilizadora evitando ruidos.", "desc_completa": "Varilla resistente soldada con alta frecuencia. Ayuda principalmente a acortar la fatiga del muelle del auto reduciendo estrepitosos 'clonks' metálicos rodando por baches.", "cat": "suspension", "active": True},
                {"nombre": "Caliper de freno", "precio": "1600", "stock": 4, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803613/25_cjcn0h.jpg", "desc_breve": "Muerde fuertemente el disco otorgando frenadas de pánico.", "desc_completa": "Dispone de pistones libres de fugas hidráulicas sellados de manera hermética. Aplica fuerza perimetral asombrosa respondiendo ágilmente a cada pisoteo del conductor.", "cat": "frenos", "active": True},
                {"nombre": "Rotor de disco de freno", "precio": "950", "stock": 11, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803589/26_xj1orj.jpg", "desc_breve": "Ventilado para evitar alabeo en pendientes.", "desc_completa": "Con una capa protectora polimérica preventiva del óxido. Funciona excelente bajo calor evitando que se doble en la presión o deforme sus diámetros con balatas pesadas.", "cat": "frenos", "active": True},
                {"nombre": "Válvula PCV", "precio": "180", "stock": 42, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803599/27_hmbamh.jpg", "desc_breve": "Libera la presión de gases nocivos cuidando los sellos.", "desc_completa": "Sencilla pero indispensable pieza ecológica y de limpieza interna. Una PCV disfuncional revienta empaques, nuestra válvula los resguarda con su muelle de cobre.", "cat": "motor", "active": True},
                {"nombre": "Empaque de cabeza", "precio": "850", "stock": 7, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803600/28_cul7ox.jpg", "desc_breve": "Sella a la perfección soportando altas presiones termales.", "desc_completa": "Una multicapa de aleaciones endurecidas que evita la trágica mezcla de acidez del escape con la refrigeración. Su instalación recupera la compresión extraviada.", "cat": "motor", "active": True},
                {"nombre": "Sensor MAF", "precio": "1150", "stock": 6, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803604/29_tv6npk.jpg", "desc_breve": "Mide con precisión la masa de aire que respira el motor.", "desc_completa": "Cuenta con filamentos platinos de sensado minucioso. Resuelve tirones engañosos en semáforos, calculando al segundo si a las válvulas de admisión les falta o sobra oxígeno.", "cat": "electrico", "active": True},
                {"nombre": "Módulo ABS", "precio": "4500", "stock": 1, "imagen": "https://res.cloudinary.com/dpvm2gro2/image/upload/v1772803582/30_gvgpfh.jpg", "desc_breve": "El cerebro para frenar sin bloquear ruedas.", "desc_completa": "Módulo distribuidor inteligente de emergencia. Analiza la presión requerida en cada neumático individualmente y modula las balatas previniendo trompos y derrapes acuáticos.", "cat": "frenos", "active": True}
            ]
            for p in productos_data:
                db.add(database.Product(**p))
            db.commit()
            print("PRODUCTOS SEMBRADOS CON ÉXITO")
        db.close()
    except Exception as e:
        print(f"Advertencia al sembrar productos: {str(e)}")

# Las semillas ya no se ejecutan automáticamente cada vez que arranca.
# seed_admin()
# seed_products()

app = FastAPI(
    title="API central Macuin",
    description="Sistema de gestión integral para la plataforma Macuin autopartes.",
    version="1.1.0"
)

# Configuración de CORS para acceso externo (portales)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], # Se debe restringir en producción
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Inclusión de routers
app.include_router(auth_router.router, prefix="/autenticacion")
app.include_router(product_router.router, prefix="/productos")
app.include_router(report_router.router, prefix="/reportes")


@app.get("/", tags=["Sistema y diagnóstico"], summary="Verificar estado del servidor")
def read_root():
    """
    Ruta raíz para diagnosticar el estado del servidor.
    """
    return {
        "estado": "En línea", 
        "manual": "/docs", 
        "puerto": 8008
    }

@app.post("/dev/reiniciar-base-datos", tags=["Sistema y diagnóstico"], summary="Reiniciar y sembrar base de datos")
def reset_and_seed():
    """
    Ruta de desarrollo para reiniciar la base de datos "desde cero" y ejecutar la semilla.
    """
    try:
        # 1. Forzar el cierre de todas las conexiones para evitar bloqueos
        database.engine.dispose()
        
        # 2. Borrar todas las tablas existentes
        database.Base.metadata.drop_all(bind=database.engine)
        
        # 3. Recrear las tablas de nuevo (vacías)
        database.Base.metadata.create_all(bind=database.engine)
        
        # 4. Ejecutar las semillas
        seed_admin()
        seed_products()
        
        return {"message": "La base de datos fue borrada y sembrada con los datos de prueba con éxito."}
    except Exception as e:
        import traceback
        print(f"ERROR EN REINICIO: {str(e)}")
        traceback.print_exc()
        raise HTTPException(status_code=500, detail=f"Error al reiniciar base de datos: {str(e)}")

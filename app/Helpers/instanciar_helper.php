<?php

if(!function_exists('menuInstanciar'))
{
	function menuInstanciar()
	{
        $json = '
        [ 
            {
                "grupo": "Bebestibles",
                "imagen": "public/images/menu/grupo-01/grupo-01.jpg",
                "producto": 
                [
                    {
                        "nombre": "Coca Cola",
                        "detalle": "La de siempre, original y deliciosa, la que refresca a millones de personas en todo el mundo.",
                        "descripcion": "El distintivo sabor a cola proviene en su mayoría de la mezcla de azúcar y aceites de naranja, limón y vainilla. Los otros ingredientes cambian el sabor tan solo ligeramente. En algunos países, como Estados Unidos y Argentina la Coca-Cola es endulzada con jarabe de maíz.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "1 Lt.",
                                "valor": "1000",
                                "base": true,
                                "show": true
                            },
                            {
                                "nombre": "Lata",
                                "valor": "800",
                                "base": false,
                                "show": true
                            },
                            {
                                "nombre": "3 Lts.",
                                "valor": "3000",
                                "base": false,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-01/01.png"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/02.png"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/03.jpg"
                            }
                        ]
                    },
                    {
                        "nombre": "Jugos Naturales",
                        "detalle": "Constamos con una gran variedad de sabores.",
                        "descripcion": "Piña - Zanahoria - Apio - Betarraga - Manzana - Limón - Jengibre - Pera - Uva - Naranja - Melón.",
                        "link": false,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "500 CC.",
                                "valor": "2500",
                                "base": true,
                                "show": true
                            },
                            {
                                "nombre": "1 Lt.",
                                "valor": "4200",
                                "base": false,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-01/04.jpg"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/05.jpg"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/06.jpg"
                            }
                        ]
                    },
                    {
                        "nombre": "Café",
                        "detalle": "Café Tostado y Molido Fina Selección.",
                        "descripcion": "Si buscas café en grano para disfrutar en tu ritual de cada día, entonces podemos ayudarte. Tenemos café de la más reciente cosecha importados desde Perú, Costa Rica, Colombia, Guatemala, Kenia, Etiopía y Brasil.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "Espresso",
                                "valor": "1800",
                                "base": true,
                                "show": true
                            },
                            {
                                "nombre": "Americano",
                                "valor": "1900",
                                "base": false,
                                "show": true
                            },
                            {
                                "nombre": "Latte",
                                "valor": "2300",
                                "base": false,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-01/07.jpg"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/08.jpg"
                            },
                            {
                                "imagen": "public/images/menu/grupo-01/09.jpg"
                            }
                        ]
                    }
                ]
            },
            {
                "grupo": "Pastas",
                "imagen": "public/images/menu/grupo-02/grupo-02.jpg",
                "producto": 
                [
                    {
                        "nombre": "PANSOTTI ALLA GENOVESE",
                        "detalle": "Los pansotti son un tipo de pasta similar a los ravioli pero mucho más grandes.",
                        "descripcion": "Son típicos de la región de Génova y, a diferencia de los ravioli, no van rellenos de carne, sino de verduras. Como curiosidad, su forma nos recuerda a un barrigón. En Génova gustan mucho con salsa de nueces y hierbas silvestres que crecen en la costa de Liguria -como los preboggion-. Para los amantes del queso, en este plato encontrarán el delicioso parmesano o el prescinseua, muy conocido en la región y con una consistencia a medio camino entre el yogur y el requesón.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "13800",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-02/01.jpg"
                            }
                        ]
                    },
                    {
                        "nombre": "SPAGUETTI AL RAGÙ ALLA BOLOGNESE ",
                        "detalle": "Platos italiano más internacional y con más variantes que existen. ",
                        "descripcion": "De ahí que sea muy complicado encontrar un lugar donde se reproduzca fielmente la receta tradicional, como la hacen los italianos de Bolonia. Originariamente, este plato se cocinaba sin tomate y la carne se cocía en vino blanco y leche. Los orígenes de esta salsa se pierden en la Antigua Roma y en la Edad Media. En Bolonia, este guiso nació en las mesas señoriales de los nobles. Hoy, la receta considerada oficial es la de Emilia Romagna, presentada en 1982 por una delegación de Bolonia en la Cámara de Comercio. En ella se hace hincapié en utilizar un corte de carne magra llamada cartella de buey o ternera (nunca de cerdo) y en sofreir las verduras con panceta.",
                        "link": true,
                        "show": false,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "11500",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-02/02.jpg"
                            }
                        ]
                    },
                    {
                        "nombre": "VERMICELLI CON LE VONGOLE",
                        "detalle": "Espaguetis con almejas.",
                        "descripcion": "Perfecto para acompañar con un buen vino blanco de la región. Se cocina con un sofrito de ajo y aceite de oliva virgen, vino blanco y almejas del Mar Adriático. Se añade una pizca de pimienta o peperoncini (un tipo de chile italiano) . Y ahora es cuando viene la pequeña disputa entre los italianos: el tomate. Hay quienes lo añaden y quienes prefieren tomarlo sin él (en este caso el plato se conoce como spaghetti alle vongole in bianco) . Dicen que la versión que lleva tomate es mucho más sabrosa. Habrá que probar las dos para comprobarlo.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "14800",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-02/03.jpg"
                            }
                        ]
                    }
                ]
            },
            {
                "grupo": "Promociones",
                "imagen": "",
                "producto": 
                [
                    {
                        "nombre": "Combo Tocino/BBQ",
                        "detalle": "Hamburguesa fresca, doble queso cheddar, tocino, salsa bbq, cebolla, pepinillos y salsa secreta + papas normales + bebida a elección",
                        "descripcion": "Hamburguesa fresca, doble queso cheddar, tocino, salsa bbq, cebolla, pepinillos y salsa secreta + papas normales + bebida a elección",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "8990",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-03/01.jpg"
                            }
                        ]
                    },
                    {
                        "nombre": "Super Dúo Mix",
                        "detalle": "2 Hamburguesas con queso, 10 Nuggets y 2 Papas Fritas Individuales.",
                        "descripcion": "2 Hamburguesas con queso, 10 Nuggets y 2 Papas Fritas Individuales.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "9990",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                        ]
                    },
                    {
                        "nombre": "Combo Tocino Aros de Cebolla",
                        "detalle": "Hamburguesa con Tocino, Aros de Cebolla, Doble Queso Cheddar, Pepinillos y salsa BBQ. Incluye papas fritas individuales y una bebida a elección.",
                        "descripcion": "Hamburguesa con Tocino, Aros de Cebolla, Doble Queso Cheddar, Pepinillos y salsa BBQ. Incluye papas fritas individuales y una bebida a elección.",
                        "link": true,
                        "show": true,
                        "precios":
                        [
                            {
                                "nombre": "",
                                "valor": "6990",
                                "base": true,
                                "show": true
                            }
                        ],
                        "imagenes":
                        [
                            {
                                "imagen": "public/images/menu/grupo-03/03.jpg"
                            }
                        ]
                    }
                ]
            }
        ]';
        
        return $json;
	}
}
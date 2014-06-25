{
    "_": "<?php printf('_%c%c}%c',34,10,10);__halt_compiler();?>",
    "blocks": {
        "form1": {
            "block": "duf/form",
            "x": 0,
            "y": 224,
            "in_con": {
                "form_def": [
                    "config",
                    "doc/examples/simple"
                ]
            }
        },
        "show1": {
            "block": "duf/show",
            "x": 259,
            "y": 196,
            "in_con": {
                "form": [
                    "form1",
                    "form"
                ]
            },
            "in_val": {
                "slot_weight": "32\n"
            }
        },
        "print_data1": {
            "block": "core/out/print_r",
            "x": 251,
            "y": 320,
            "in_con": {
                "enable": [
                    "form1",
                    "done"
                ],
                "data": [
                    "form1",
                    "contact"
                ]
            },
            "in_val": {
                "title": "Submitted data",
                "header_level": 3,
                "slot_weight": 35
            }
        },
        "form2": {
            "block": "duf/form",
            "x": 14,
            "y": 743,
            "in_con": {
                "form_def": [
                    "config",
                    "doc/examples/list"
                ]
            }
        },
        "show2": {
            "block": "duf/show",
            "x": 253,
            "y": 664,
            "in_con": {
                "form": [
                    "form2",
                    "form"
                ]
            },
            "in_val": {
                "slot_weight": 42
            }
        },
        "print_data2": {
            "block": "core/out/print_r",
            "x": 254,
            "y": 795,
            "in_con": {
                "enable": [
                    "form2",
                    "done"
                ],
                "data": [
                    ":array",
                    "form2",
                    "quest",
                    "form2",
                    "objectives"
                ]
            },
            "in_val": {
                "title": "Submitted data",
                "header_level": 3,
                "slot_weight": 45
            }
        },
        "header2": {
            "block": "core/out/header",
            "x": 250,
            "y": 466,
            "in_val": {
                "level": 2,
                "text": "List Form",
                "slot_weight": 40
            }
        },
        "header1": {
            "block": "core/out/header",
            "x": 254,
            "y": 0,
            "in_val": {
                "level": 2,
                "text": "Simple Form",
                "slot_weight": 30
            }
        }
    }
}
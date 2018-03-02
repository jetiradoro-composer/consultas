config = {
    tables: {
        'name': 'Consultas',
//    Taules de la base de dades per agafar les entitats principals
        'tables': [
            {
                'table': 'V_MKT_CAPTACIONS',
                'entity': 'Captacions',
                'fields': {
                    'ID': 'ID',
                    'DNI': 'DNI',
                    'NOM': 'NOM',
                    'COGNOM1': 'COGNOM1',
                    'COGNOM2': 'COGNOM2',
                    'EMAIL': 'EMAIL',
                    'TELEFON': 'TELEFON',
                    'DATA NEIXAMENT': 'DATA_NAIXAMENT',
                    'ADREÇA': 'ADRECA',
                    'POBLACIO_ID': 'POBLACIO_ID',
                    'POBLACIO': 'POBLACIO',
                    'PROVINCIA_ID': 'PROVINCIA_ID',
                    'PROVINCIA': 'PROVINCIA',
                    'ESTUDI_INFORMAT': 'ESTUDI_INFORMAT',
                    'ESTUDI_PREVIST': 'ESTUDI_PREVIST',
                    'TEMPERATURA': 'TEMPERATURA',
                    'CENTRE_ID': 'CENTRE_ID',
                    'CENTRE': 'CENTRE',
                    'CENTRE_TIPUS': 'CENTRE_TIPUS',
                    'CENTRE_BATX': 'CENTRE_BATX',
                    'CENTRE_ESO': 'CENTRE_ESO',
                    'CENTRE_CFGM': 'CENTRE_CFGM',
                    'CENTRE_CFGS': 'CENTRE_CFGS',
                    'CENTRE_MULTIL': 'CENTRE_MULTIL',
                    'CAPTACIO_ID': 'CAPTACIO_ID',
                    'ACCIO_ID': 'ACCIO_ID',
                    'ACCIO': 'ACCIO',
                    'ACCIO_CURS_ID': 'ACCIO_CURS_ID',
                    'ACCIO_EDICIO': 'ACCIO_EDICIO',
                    'DESCRIPTION': 'DESCRIPTION',
                    'ACCIO_CURS': 'ACCIO_CURS',
                    'DATE_ACCIO': 'DATE_ACCIO',
                },
                'filters': {
                    'ACCIÓ': 'ACCIO_ID'
                },
            },
            {
                'table': 'V_MKT_CAPTACIONS',
                'entity': 'Persones',
                'fields': {
                    'ID': 'ID',
                    'DNI': 'DNI',
                    'NOM': 'NOM',
                    'COGNOM1': 'COGNOM1',
                    'COGNOM2': 'COGNOM2',
                    'EMAIL': 'EMAIL',
                    'TELEFON': 'TELEFON',
                    'DATA NEIXAMENT': 'DATA_NAIXAMENT',
                    'ADREÇA': 'ADRECA',
                    'ACCIO_CURS_ID': 'ACCIO_CURS_ID',
                    'ACCIO_EDICIO': 'ACCIO_EDICIO',
                    'DESCRIPTION': 'DESCRIPTION',
                    'ACCIO_CURS': 'ACCIO_CURS',
                    'DATE_ACCIO': 'DATE_ACCIO',
                },
                'filters': {
                    'ACCIÓ': 'ACCIO_ID'
                },
            }
        ]

    },
};
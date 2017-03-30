ag.api.Endpoint.register({
    "syslog.v1/Syslog.search": [
        "syslog.v1/SyslogSearch",
        "syslog.v1/Logentry[]"
    ]
});
ag.api.Object.register({
    "syslog.v1/Logentry": {
        "props": {
            "created": {
                "type": "object",
                "class": "common.v1/DateTime"
            },
            "category": {
                "type": "object",
                "class": "syslog.v1/LogentryCategory"
            },
            "user": {
                "type": "object",
                "class": "syslog.v1/User"
            },
            "level": {
                "type": "string"
            },
            "message": {
                "type": "string"
            },
            "id": {
                "type": "integer",
                "readonly": true
            }
        }
    },
    "syslog.v1/LogentryCategory": {
        "props": {
            "id": {
                "type": "string"
            },
            "name": {
                "type": "string"
            }
        }
    },
    "syslog.v1/User": {
        "props": {
            "email": {
                "type": "string"
            },
            "id": {
                "type": "integer",
                "readonly": true
            },
            "name": {
                "type": "string",
                "minLength": 1
            }
        }
    },
    "syslog.v1/SyslogSearch": {
        "props": {
            "type": {
                "type": "string",
                "values": [
                    "all",
                    "important",
                    "critical"
                ],
                "default": "all"
            },
            "term": {
                "type": "string",
                "nullable": true
            },
            "offset": {
                "type": "integer",
                "minValue": 0,
                "default": 0
            },
            "limit": {
                "type": "integer",
                "minValue": 1,
                "maxValue": 200,
                "default": 50
            },
            "period": {
                "type": "object",
                "class": "common.v1/Period",
                "nullable": true
            }
        }
    }
});

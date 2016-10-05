ag.api.Endpoint.register({
    "syslog.v1/Syslog.search": [
        "syslog.v1/SyslogSearch",
        "syslog.v1/Logentry[]"
    ]
});
ag.api.Object.register({
    "syslog.v1/Logentry": {
        "props": {
            "id": {
                "type": "number"
            },
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
            "id": {
                "type": "number"
            },
            "name": {
                "type": "string"
            },
            "email": {
                "type": "string"
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
                "type": "number",
                "minValue": 0,
                "default": 0
            },
            "limit": {
                "type": "number",
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

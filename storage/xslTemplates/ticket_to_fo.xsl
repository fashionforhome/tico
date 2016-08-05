<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml"/>

	<xsl:template match="ticket">
		<fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">

			<fo:layout-master-set>
				<fo:simple-page-master master-name="A6" page-width="148mm" page-height="105mm" margin-top="5mm" margin-bottom="3mm">
					<fo:region-body/>
					<fo:region-before extent="15mm"/>
					<fo:region-after extent="13mm"/>
					<fo:region-start extent="13mm"/>
					<fo:region-end extent="13mm"/>
				</fo:simple-page-master>
			</fo:layout-master-set>

			<fo:page-sequence master-reference="A6">
				<fo:static-content flow-name="xsl-region-start">
					<fo:block>
						<!-- init space to expand row -->
						<xsl:text>&#xA0;</xsl:text>
					</fo:block>
				</fo:static-content>

				<fo:static-content flow-name="xsl-region-end">
					<fo:block>
						<!-- init space to expand row -->
						<xsl:text>&#xA0;</xsl:text>
					</fo:block>
				</fo:static-content>
				<!-- HEADER -->
				<fo:static-content flow-name="xsl-region-before">
					<fo:wrapper text-align="left">
						<fo:table table-layout="fixed" width="100%">
							<fo:table-column column-width="128mm"/>
							<fo:table-body>
								<fo:table-row>
									<fo:table-cell>
										<xsl:choose>
											<xsl:when test="issueType">
												<fo:block text-align="right" margin-right="5mm">
													<fo:external-graphic content-height="scale-to-fit" height="6mm">
														<xsl:attribute name="src">
															<xsl:value-of select="imagePath" />
														</xsl:attribute>
													</fo:external-graphic>
												</fo:block>
											</xsl:when>
											<!-- Parent-Ticket Info -->
											<xsl:when test="parent">
												<fo:block>
													<!-- init space to expand row -->
													<xsl:text>&#xA0;</xsl:text>

													<xsl:value-of select="key"/>
													<!-- space between parent key & summary -->
													<xsl:text>&#xA0;&#xA0;&#xA0;</xsl:text>
													<xsl:choose>
														<xsl:when test="string-length(summary/text()) > 45">
															<xsl:value-of select="concat(substring(summary, 0, 44), '...')"/>
														</xsl:when>
														<xsl:otherwise>
															<xsl:value-of select="summary"/>
														</xsl:otherwise>
													</xsl:choose>
												</fo:block>
											</xsl:when>
											<!-- Empty Block -->
											<xsl:otherwise>
												<fo:block>
													<!-- init space to expand row -->
													<xsl:text>&#xA0;</xsl:text>
												</fo:block>
											</xsl:otherwise>
										</xsl:choose>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>

						<!-- bottom border -->
						<fo:block border-bottom-color="black" border-bottom-style="dashed" border-bottom-width="0.2mm" space-after="3mm" wrap-option="no-wrap"/>
					</fo:wrapper>
				</fo:static-content>

				<!-- FOOTER -->
				<fo:static-content flow-name="xsl-region-after">
					<fo:wrapper font-family="sans-serif" text-align="left" font-weight="bold" font-size="3mm">
						<!-- top border -->
						<fo:block border-top-color="black" border-top-style="dashed" border-top-width="0.2mm"></fo:block>

						<fo:table table-layout="fixed" width="100%" margin-top="4mm">
							<fo:table-column column-width="40mm"/>
							<fo:table-column column-width="50mm"/>
							<fo:table-column column-width="38mm"/>
							<fo:table-body>
								<fo:table-row>
									<!-- Assignee -->
									<fo:table-cell>
										<fo:block>
											<xsl:text>(A)&#xA0;</xsl:text>
										</fo:block>
									</fo:table-cell>
									<!-- Devteam -->
									<fo:table-cell>
										<fo:block>
											<xsl:value-of select="devTeam"/>
										</fo:block>
									</fo:table-cell>
									<!-- Reviewed by -->
									<fo:table-cell>
										<fo:block font-size="3mm" font-weight="normal">
											<xsl:text>reviewed by:</xsl:text>
										</fo:block>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>
					</fo:wrapper>
				</fo:static-content>

				<!-- CONTENT BODY -->
				<fo:flow flow-name="xsl-region-body">
					<fo:table table-layout="fixed" width="100%" margin-top="10mm" font-size="3mm" margin-left="7.5mm">
						<fo:table-column column-width="75mm"/>
						<fo:table-column column-width="53mm"/>
						<fo:table-body>
							<fo:table-row>
								<!-- Key -->
								<fo:table-cell>
									<fo:block font-family="sans-serif" font-size="20mm" font-weight="bold">
										<xsl:choose>
											<xsl:when test="contains(key/text(), 'DMF')">
												<xsl:value-of select="substring-after(key,'-')"/>
											</xsl:when>
											<xsl:otherwise>
												<xsl:value-of select="key"/>
											</xsl:otherwise>
										</xsl:choose>
									</fo:block>
								</fo:table-cell>
								<!-- Reporter -->
								<fo:table-cell>
									<fo:block text-align="right" margin-top="15mm">
										<xsl:text>(R) </xsl:text>
										<xsl:value-of select="reporter"/>
									</fo:block>
								</fo:table-cell>
							</fo:table-row>
						</fo:table-body>
					</fo:table>

					<!-- Summary -->
					<fo:table table-layout="fixed" width="100%" font-size="7mm" font-weight="bold" margin-left="7.5mm">
						<fo:table-column column-width="128mm"/>
						<fo:table-body>
							<fo:table-row>
								<fo:table-cell>
									<fo:block font-family="sans-serif" text-align="left" wrap-option="wrap" margin-top="6mm">
										<xsl:choose>
											<xsl:when test="string-length(summary/text()) > 120">
												<xsl:value-of select="concat(substring(summary, 0, 117), '...')"/>
											</xsl:when>
											<xsl:otherwise>
												<xsl:value-of select="summary"/>
											</xsl:otherwise>
										</xsl:choose>
									</fo:block>
								</fo:table-cell>
							</fo:table-row>
						</fo:table-body>
					</fo:table>
					<fo:block-container position="absolute" top="72mm" left="-1mm">
						<fo:table table-layout="fixed" width="100%" margin-bottom="2mm" font-size="7mm" font-weight="bold" margin-left="7.5mm">
							<fo:table-column column-width="87mm"/>
							<fo:table-column column-width="40mm"/>
							<fo:table-body>
								<fo:table-row>
									<fo:table-cell>
										<fo:block text-align="left">
										</fo:block>
									</fo:table-cell>
									<fo:table-cell>
										<fo:block text-align="right">
											<xsl:value-of select="storyPoints"/>
										</fo:block>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>
					</fo:block-container>
					<fo:block-container position="absolute" top="73.5mm" left="-1mm">
						<fo:table table-layout="fixed" width="90%" margin-bottom="2mm" font-size="3mm" margin-left="7.5mm">
							<fo:table-column column-width="87mm"/>
							<fo:table-column column-width="45mm"/>
							<fo:table-body>
								<fo:table-row>
									<fo:table-cell display-align="after" height="10.5mm">
										<fo:block text-align="left">
											<xsl:choose>
												<!-- Epic-Ticket Info -->
												<xsl:when test="epic">
													<fo:block>
														<!-- init space to expand row -->
														<xsl:text>&#xA0;</xsl:text>

														<xsl:value-of select="epic/key"/>
														<!-- space between epic key & summary -->
														<xsl:text>&#xA0;&#xA0;&#xA0;</xsl:text>
														<xsl:value-of select="concat(substring(epic/summary, 0, 49), '...')"/>
													</fo:block>
												</xsl:when>
											</xsl:choose>
										</fo:block>
									</fo:table-cell>
									<fo:table-cell display-align="after" height="10.5mm">
										<fo:block text-align="right">
											<xsl:value-of select="sprint"/>
										</fo:block>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>
					</fo:block-container>
				</fo:flow>
			</fo:page-sequence>

		</fo:root>
	</xsl:template>

</xsl:stylesheet>